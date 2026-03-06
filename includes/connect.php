<?php 
$host = "localhost"; //hostname
$db = "book_manager"; //database name
$user = "root"; //username
$password = ""; //password

//points to the database
$dsn = "mysql:host=$host;dbname=$db";

//try to connect
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
//show the error if something goes wrong with the connection
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
