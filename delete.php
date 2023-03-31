<?php
include_once('header.php');

function removeAd($id) {
    global $conn;
    $user_id = $_SESSION["USER_ID"];
	$query = "SELECT * FROM ads WHERE user_id='$user_id' AND id = '$id'";
	if($conn->query($query)) {
		$query = "DELETE FROM ads WHERE user_id='$user_id' AND id = '$id'";
        $conn->query($query);
        header("Location: myads.php");
	} else {
        header("Location: logout.php");
    }
}

removeAd($_GET["id"]);

?>