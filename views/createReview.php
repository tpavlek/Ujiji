<?php

if (!isset($_GET['email'])) {
    echo "You must choose a user to review";
    echo "<a href='index.php'>Go home</a>";
    die();
}


?>

<form action="process.php?type=review&method=create" method="POST">
  <input type="radio" name="rating" value="1">1 (poor)
  <input type="radio" name="rating" value="2">2
  <input type="radio" name="rating" value="3">3
  <input type="radio" name="rating" value="4">4
  <input type="radio" name="rating" value="5" checked>5 (excellent)
  <br>
  <br>
  <textarea name="review_text"></textarea>
  <br>
  <br>
  <input type="hidden" name='email' value='<?php echo $_GET['email']; ?>' />
  <input type="submit" class="btn btn-success" value="Save Review" />
</form>