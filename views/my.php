<?php
require_once('fragments/Ad.php');
$pageNum = (isset($_GET['page_num'])) ? $_GET['page_num'] : 0;
$adList = $page->getDB()->getUserAds($_SESSION['email'], $pageNum);
$offers = $page->getDB()->getOffers();


?>
<form action="process.php?type=ad" method="POST">
    <?php
    foreach ($adList as $ad) {
      echo "<input type='checkbox' name='ads[]' value='". $ad->getAid() ."'/>";
      $fragment = new AdFragment($ad);
      print $fragment->getBox();
        $promotion = $page->getDB()->isAdOnPromotion($ad->getAid());
      ?>
      <div class="row-fluid">
        <div class="span6">
          On promotion: <?php echo ($promotion) ? "Yes" : "No"; ?>
        </div>
        <div class="span6">
          Promotion Ends: <?php echo ($promotion) ? round($promotion, 1) . " days" : "N/A"; ?>
        </div>
      </div>
    <?php
    }
    ?>
    <div class="row-fluid">
      <div class="span6">
    I want to (select checkboxes on above ads):<br>
  <input type="radio" name="method" value="delete" checked>Delete Ads<br>
  <input type="radio" name="method" value="promote">Promote Ads<br>
  <select name="ono">
      <?php
      foreach ($offers as $offer) {
          echo "<option value='" .$offer->getOno() ."'>" . $offer->getNumDays() . " days | $" . $offer->getPrice()
                . "</option>";
      }

      ?>
  </select>
        </div>
        <div class="span6">
          <input type="submit" class='btn btn-success' value="Go" />
        </div>
      </div>

</form>

  <br>
    <br>
      <?php if (count($offers) == 5) { ?>
      <a href='index.php?page=my&pageNum='<?php echo $pageNum +1; ?>'>Next Page</a>
    <?php } ?>