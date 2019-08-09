<?php
    // PayPal's instant payment notification
    include_once("dbconnection.php");

    header('HTTP/1.1 200 OK');

    // Create the response we need to send back to PayPal for them to confirm that it's legit

    $resp = 'cmd=_notify-validate';
    foreach ($_POST as $parm => $var) {
        $var = urlencode(stripslashes($var));
        $resp .= "&$parm=$var";
    }

    $itemNames = array();
    $itemQuantities = array();
    $itemGross = array();
    //get all item names and quantities into an array (keep the for loop until last item cannot be found)
    for ($i = 1; $i < 999999; $i ++) {
        if (isset($_POST['item_name' . $i])) {
            $itemNames[$i] = $_POST['item_name' . $i];
            $itemQuantities[$i] = $_POST['quantity' . $i];
            $itemGross[$i] = $_POST['mc_gross_' . $i];
        } else {
            break;
        }
    }

    //convert the arrays into strings
    $namesItems = implode(",", $itemNames);
    $quantitiesItems = implode(",", $itemQuantities);
    $grossItems = implode(",", $itemGross);

    // Extract the data PayPal IPN has sent us, into local variables
    $payment_status = $_POST['payment_status']; //status of payment
    $payment_amount = $_POST['mc_gross']; //total gross amount
    $payer_email = $_POST['payer_email']; //customer email
    $payment_date = $_POST['payment_date']; //payment date

    // Get the HTTP header into a variable and send back the data we received so that PayPal can confirm it's genuine

    $httphead = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $httphead .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $httphead .= "Content-Length: " . strlen($resp) . "\r\n\r\n";

     // Now create a ="file handle" for writing to a URL to paypal.com on Port 443 (the IPN port)

    $errno ='';
    $errstr='';

    $fh = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

    // Now send the data back to PayPal so it can tell us if the IPN notification was genuine

    if (!$fh) {

    // Uh oh. This means that we have not been able to get thru to the PayPal server.  It's an HTTP failure
    }

    // Connection opened, so spit back the response and get PayPal's view whether it was an authentic notification

    else {
        fputs($fh, $httphead . $resp);
        while (!feof($fh)) {
            $readresp = fgets($fh, 1024);
            if ($payment_status == "Completed") {
                //Success! The purchase was validated.
           $payment_status = "Paid_Once"; //the code will no longer loop the database update

           //add the information into the transactions table in the MySQL database
                $query = "INSERT INTO transactions (Customer_Email, Gross_Amount, Payment_Date, Items_Purchased, Items_Quantities, Items_Gross) VALUES('$payer_email', '$payment_amount', '$payment_date', '$namesItems', '$quantitiesItems', '$grossItems')";
                mysqli_query($link, $query);
            } elseif (strcmp($readresp, "INVALID") == 0) {
                //Failed attempt, or we're done with updating the database.
            }
        }
        fclose($fh);
    }
