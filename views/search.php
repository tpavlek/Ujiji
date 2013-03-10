<?php
require_once('fragments/Ad.php');

if (!isset($_POST['search_term'])) { ?>
  <form action="index.php?page=search" class="form-horizontal" method="POST">
    <div class="control-group">
      <label class="control-label">Search Terms (space separated): </label>
      <div class="controls">
        <input type="text" name="search_term">
        <label class="radio">
          <input type="radio" name="search_type" value="1" checked />Ad
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
    <input type="submit" class='btn btn-success' value="Search">
  </form>

<?php
} else {
  if ($_POST['search_type'] == 1) {
    $terms = explode(" ", $_POST['search_term']);
    $resultSet = $page->getDB()->adSearch($terms, $_POST['page_num']);
    foreach ($resultSet as $ad) {
        $fragment = new AdFragment($ad);
        print $fragment->getBox();
    }
      if (count($resultSet) == 0) {
          echo "No Ads to display";
      }
      if (count($resultSet) == 5) {
          echo "<form action='index.php?page=search' method='POST'>
            <input type='hidden' value='" . $_POST['search_term'] . "' name='search_term' />
            <input type='hidden' value='" . $_POST['search_type'] . "' name='search_type' />
            <input type='hidden' value='" . ($_POST['page_num'] +1) . "' name='page_num' />
            <input type='submit' class='btn btn-primary' value='Load Next Page' />
          </form>
          ";
      }
  } else if ($_POST['search_type'] == 2) {
    $resultSet = $page->getDB()->userSearch($_POST['search_term'], $_POST['page_num']);
      echo count($resultSet) . " results returned on this page <br>";
    foreach ($resultSet as $user) {
      print "<a href='index.php?page=viewUser&email=". $user->getEmail() . "'>". $user->getName() . "</a><br>";
    }

  } else {
    if ($page->getDB()->isInDatabase("user", $_POST['search_term'])) {
      echo "<a href='index.php?page=viewUser&email=" . $_POST['search_term'] . "'>View User</a>";
    } else {
      echo "User Not Found";
    }
  }
  ?>

<?php
}
?>