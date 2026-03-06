<?php
require   "includes/header.php";
require  "includes/connect.php";

/*
 * update.php
 * ------------------------------------------------------------
 * Admin update page for review.


### 3. Update (5 marks) 

// The admin must be able to:

// - Select a review
// - Load the existing data into a form
// - Edit the values
// - Save the changes to the database

// ---


/* -------------------------------------------
   STEP 1: Make sure we received an ID in the URL
   Example: update.php?id=5
-------------------------------------------- */
if (!isset($_GET['id'])) {
  die("No review ID provided.");
}

$reviewId = $_GET['id'];

/* -------------------------------------------
   STEP 2: If form is submitted, UPDATE the row
-------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Basic sanitization (trim removes extra spaces)
  $title = trim($_POST['title'] ?? '');
  $author  = trim($_POST['author'] ?? '');
  $review_text     = trim($_POST['review_text'] ?? '');

  // int rating
  $rating       = (int)($_POST['rating'] ?? 0);

  // Simple validation (beginner-friendly)
  if ($author === '' || $title === '' || $review_text === '' || $rating ==='') {
    $error = "Title, author, rating and review are required.";
  } else {

    $sql = "UPDATE reviews
            SET title = :title,
                author = :author,
                review_text = :review_text,
                rating = :rating
                where id = :id";


    $stmt = $pdo->prepare($sql);

    // Bind parameters (safe + beginner friendly)
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':review_text', $review_text);

    $stmt->bindParam(':id', $reviewId);

    $stmt->execute();

    // Redirect back to the reviews list (prevents resubmission on refresh)
    header("Location: reviews.php");
    exit;
  }
}

/* -------------------------------------------
   STEP 3: Load existing review data (to echo in the form)
-------------------------------------------- */
$sql = "SELECT * FROM reviews WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $reviewId);
$stmt->execute();

$review = $stmt->fetch();

if (!$review) {
  die("Review not found.");
}
?>

<main class="container mt-4">
  <h2>Update Review #<?= htmlspecialchars($review['id']); ?></h2>

  <?php if (!empty($error)): ?>
    <p class="text-danger"><?= htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <!--
    This form is pre-filled using the review data pulled from the database.
    The admin can edit the values and submit to update the row.
  -->
  <form method="post">

    <h4 class="mt-3">Review Info</h4>

    <label >Title</label>
    <input
      type="text"
      name="title"
      value="<?= htmlspecialchars($review['title']); ?>"
      required
    >

    <label >Author</label>
    <input
      type="text"
      name="author"
      value="<?= htmlspecialchars($review['author']); ?>"
      required
    >

    <label class="form-label">Rating</label>
    <input
      type="number"
      name="rating"
      value="<?= htmlspecialchars($review['rating']); ?>"
    >

    <label class="form-label">Review</label>
    <input
      type="text"
      name="review_text"
      value="<?= htmlspecialchars($review['review_text']); ?>"
    >



    <button >Save Changes</button>
    <a href="reviews.php" class="btn btn-secondary">Cancel</a>

  </form>
</main>
<?php
require   "includes/footer.php";
?>