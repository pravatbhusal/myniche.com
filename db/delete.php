<?php
include("dbconnection.php");
$website = "http://$_SERVER[HTTP_HOST]";
$Niche_Type = $_POST["nicheType"];
$Item_Name = $_POST["itemName"];

$query = "DELETE FROM $Niche_Type WHERE Item_Name = '$Item_Name'";

//deleted the item successfully
if(mysqli_query($link, $query)) {
	header("refresh:10;url=$website");
	echo '<h2 style="color:green">Success, the item '.$Item_Name.' was deleted from the database!</h2>';
	echo 'Redirecting in 10 seconds...';
	exit;
} else {
	header("refresh:10;url=$website");
	echo '<h2 style="color:red">Error connecting to the database...</h2>';
	echo 'Redirecting in 10 seconds...';
	exit;
}
?>