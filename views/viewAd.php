<?php

$ad = $page->getDB()->getAd($_GET['aid']);

?>

<div class="row-fluid">
  <div class="span8">
    <h3> <?php echo $ad->getTitle(); ?></h3>
  </div>
  <div class="span4">
    <span><?php echo $ad->getPrice(); ?></span>
  </div>
</div>
<div class="well">
  <?php echo $ad->getDesc(); ?>
</div>

