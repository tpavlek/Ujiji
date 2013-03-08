<?php
$pageNum = (isset($_GET['page_num'])) ? $_GET['page_num'] : 0;
$adList = $page->getDB()->getUserAds($_SESSION['email'], $pageNum);


foreach ($adList as $ad) {
  echo $ad;
}
?>