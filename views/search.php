<?php

if (!isset($_POST['search_term'])) { ?>
  <form action="search.php" class="form-horizontal" method="POST">
    <div class="control-group">
      <label class="control-label">Search Terms (space separated): </label>
      <div class="controls">
        <input type="text" name="search_term">
        <label class="radio">
          <input type="radio" name="search_type" value="1" />Ad
        </label>
        <label class="radio">
          <input type="radio" name="search_type" value="2" />User (name)
        </label>
        <label class="radio">
          <input type="radio" name="search_type" value="3" />User (email)
        </label>
        <input type="hidden" value="0" name="page_num" />
      </div>
    </div>
    <input type="text">
  </form>

<?php
} else {
  if ($_POST['search_type'] == 1) {
    $terms = explode(" ", $_POST['search_term']);
    $resultSet = $page->getDB()->adSearch($terms, $_POST['page_num']);
    foreach ($resultSet as $ad) {
      echo "<div class='well'>";
      echo "<h3>" . $ad->getTitle() . "</h3>";
      echo "<i>" . $ad->getType() . "</i>";
      echo $ad->getPrice();
      echo $ad->getDate();
      echo "<a href='index.php?page=viewAd.php&aid=" . $ad->getAid() . "'>See more</a>";
      echo "</div>";
    }
  } else if ($_POST['search_type'] == 2) {
    $resultSet = $page->getDB()->userSearch($name, $POST['page_num']);
    foreach ($resultSet as $user) {
      print $user;
    }

  } else {
    if ($page->getDB()->isInDatabase("user", $_POST['search_term'])) {
      echo "<a href='index.php?page=viewUser.php&email=" . $_POST['search_term'] . "'>View User</a>";
    } else {
      echo "User Not Found";
    }
  }
  ?>

<?php
}
?>