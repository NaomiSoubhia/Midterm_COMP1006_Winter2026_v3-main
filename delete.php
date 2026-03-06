<?php
/**
 * delete.php
 */
//connect to db
require "includes/connect.php";


// make sure we received an ID

$reviewId = $_GET['id'];

if (!isset($_GET['id'])) {
  die("No review ID provided.");
}



// create the query 
$sql = "DELETE FROM reviews where id = :id";
//prepare 
$stmt = $pdo->prepare($sql);

//bind 
$stmt->bindParam(':id', $reviewId);

//execute
$stmt->execute();

// Redirect back to admin list
header("Location: reviews.php");
exit;
