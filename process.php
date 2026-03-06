<?php
//Connecting the database
require "includes/connect.php";  




// 1. Submit a Book Review (Create) (5 marks) 

// Using the provided HTML form:

// - Accept user input
// - Sanitize and validate the form data on the server
// - If valid, store the review in the database
// - If invalid, display an error message and do not insert the record



//Check if the method of the form is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

//Access the form data and sanatize data
$title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
$author  = trim(filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS));
$rating     = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
$review     = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_SPECIAL_CHARS));

//Store the errors 
$errors = [];

// Required fields
if ($title === null || $title === '') {
    $errors[] = "Title is required.";
}

if ($author === null || $author === '') {
    $errors[] = "Author is required.";
}

// Rating: required + format check
if ($rating === null || $rating === '') {
    $errors[] = "Rating is required.";
} elseif (!filter_var($rating, FILTER_VALIDATE_INT)) {
    $errors[] = "Rating must be a valid integer number.";
}


// Review: required
if ($review === null || $review === '') {
    $errors[] = "Review is required.";
}

// If there are errors, show them and stop the script before inserting to the DB
if (!empty($errors)) {
    require "includes/header.php";   
    echo "<div class='alert alert-danger'>";
    echo "<h2>Please fix the following:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        // htmlspecialchars() prevents any unexpected HTML from being rendered
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "</div>";

    require "includes/footer.php";
    exit;
}


//Build our query using named placeholders and using the prepared statement
$sql = "INSERT INTO reviews (title, author, rating, review_text) values (:title, :author, :rating, :review)";

//Prepare the query
$stmt= $pdo->prepare($sql);

//Map the named placeholder to the user data/actual data
$stmt->bindParam(':title', $title);
$stmt->bindParam(':author', $author);
$stmt->bindParam(':rating', $rating);
$stmt->bindParam(':review', $review);

//Execute the query
$stmt ->execute();

//Close the connection
$pdo = null;

?>
<? require "includes/header.php"; ?> 
<div >
    <h1>Thank you for your review about the book <?= htmlspecialchars($title) ?>!</h1>
    <p>
        We’ve received your review!
    </p>
</div>

<?php require "includes/footer.php"; ?>
