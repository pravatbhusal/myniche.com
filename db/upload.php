<?php
include("dbconnection.php");
$website = "http://$_SERVER[HTTP_HOST]";
$Niche_Type = $_POST["nicheType"];
$Item_Name = $_POST["itemName"];
$Item_Price = $_POST["itemPrice"];
$Item_Description = $_POST["itemDescription"];

$unique_hash = md5(uniqid(rand(), true)); //generate a unique hash
$icon = "db/icons/$Niche_Type/" . $unique_hash;
$icon .= preg_replace("/[^A-Za-z0-9 \.\-_]/", '', $_FILES['itemPicture']['name']);

//add the item into the database
$query = "INSERT INTO $Niche_Type (Item_Name, Price, Item_Description, icon) VALUES('$Item_Name', '$Item_Price', '$Item_Description', '$icon')";
if (mysqli_query($link, $query)) {
    header("refresh:10;url=$website");
    echo '<h2 style="color:green">Success, the item '.$Item_Name.' was uploaded into the file system!</h2>';
    echo 'Redirecting in 10 seconds...';
} else {
    header("refresh:10;url=$website");
    echo '<h2 style="color:red">Error connecting to the database...</h2>';
    echo 'Redirecting in 10 seconds...';
    exit;
}

//upload the icon into the file directory
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //uploading icon
    if (is_uploaded_file($_FILES['itemPicture']['tmp_name'])) {
        $upload_file_name = $unique_hash;

        //replace any non-alpha-numeric cracters in the file name
        $upload_file_name .= preg_replace("/[^A-Za-z0-9 \.\-_]/", '', $_FILES['itemPicture']['name']);

        //Save the file
        $dest=__DIR__.'/icons/'.$Niche_Type.'/'.$upload_file_name;
        if (move_uploaded_file($_FILES['itemPicture']['tmp_name'], $dest)) {
            //success
        }
    }
}
exit;
