<?php
require_once('page.php');

class AdFragment extends Page {

  private $ad;
  public function __construct($aid) {
    $this->ad = $page->getDB()->getAd($aid);
  }


}

?>