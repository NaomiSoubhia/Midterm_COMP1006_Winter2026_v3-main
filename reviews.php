<?php
require "includes/header.php";
require "includes/connect.php";

/**
 * Admin view: list all reviews and provide an Update and Delete button.
 * Clicking Update sends the review id to update.php via the URL.
 */


// ### 2. Admin Page (Read) (5 marks) 

// Create an admin page that:

// - Retrieves all book reviews from the database
// - Displays them in a dynamically generated HTML table
// - Includes Update and Delete options for each review



// Get all reviews (newest first)
$sql = "SELECT * FROM reviews ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$reviews = $stmt->fetchAll();
?>

<main class="mt-4">
  <h2>Reviews (Admin)</h2>

  <?php if (empty($reviews)): ?>
    <p>No reviews yet.</p>
  <?php else: ?>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
             <th>Rating</th>
            <th>Review</th>
            <th>Created at</th>

          </tr>
        </thead>

        <tbody>
          <?php foreach ($reviews as $review): ?>

            <tr>
              <td><?= htmlspecialchars($review['id']); ?></td>

              <td><?= htmlspecialchars($review['title']); ?></td>
              <td><?= htmlspecialchars($review['author']); ?></td>
               <td><?= htmlspecialchars($review['rating']); ?></td>
              <td><?= htmlspecialchars($review['review_text']); ?></td>

              <td><?= htmlspecialchars($review['created_at']); ?></td>

              <td>
                <!-- Sends the ID to update.php -->
                <a
                  href="update.php?id=<?= urlencode($review['id']); ?>">
                  Update
                </a>
                <a
                  href="delete.php?id=<?= urlencode($review['id']); ?>"
                  onclick="return confirm('Are you sure you want to delete this review?');">
                  Delete
                </a>
              </td>
            </tr>

          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php endif; ?>
  <a href="index.php">Back to Review Form</a>
</main>

<?php
require   "includes/footer.php";
?>