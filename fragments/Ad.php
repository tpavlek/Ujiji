<?php
require_once('page.php');

class AdFragment extends Page {

  private $ad;

  public function __construct($ad) {
    $this->ad = $ad;
  }

    function getBox() {
        $str = "<div class='well'>
            <div class='row-fluid'>
                <div class='span8'>
                    <h4>" . $this->ad->getTitle() . "</h4>
                </div>
                <div class='span4'>
                    Price: <em>" . $this->ad->getPrice() . "</em>
                </div>
            </div>
            Type: <i>" . $this->ad->getType() . "</i><br>
            Date: " . $this->ad->getDate() . "<br>
            <a class='btn btn-info' href='index.php?page=viewAd&aid=" . $this->ad->getAid() . "'>See more</a>
        </div>";
        return $str;
    }


}

?>