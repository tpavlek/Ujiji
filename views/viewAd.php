<?php
require_once('Ad.php');

$ad = new Ad($_GET['aid']);

?>

<div class="row-fluid">
  <div class="span8">
    <h3> <?php echo $ad->getTitle(); ?></h3>
  </div>
  <div class="span4">
    <span>Price: <?php echo $ad->getPrice(); ?></span>
  </div>
</div>
<div class="well">
    <div class="row-fluid">
      <div class="span4">Author: <a href='?page=viewUser&email=<?php echo $ad->getAuthor();?>'>
          <?php echo $ad->getAuthor(); ?>
        </a>
      </div>
      <div class="span4">Avg Rtg: <?php echo $page->getDB()->getAvgRating($ad->getAuthor()) ?></div>
      <div class="span4">Loc: <?php echo $ad->getLocation(); ?></div>
    </div>
    Type: <?php echo $ad->getType(); ?><br>
    Date: <?php echo $ad->getDate(); ?><br>
    Category: <?php echo $ad->getCategory(); ?><br>
    <br>
    <p> Description: <br>
  <?php echo $ad->getDesc(); ?>
  </p>
</div>

