<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ebon
 * Date: 09/03/13
 * Time: 09:54
 * To change this template use File | Settings | File Templates.
 */

class ReviewFragment {

    private $review;

    public function __construct($review) {
        $this->review = $review;
    }

    function getBox($full = FALSE) {
        $str = "<h3>Review by: " . $this->review->getAuthor() . "</h3>
        <div class='well'>
            <div class='row-fluid'>
                <div class='span8'>
                    <strong>Rating:" . $this->review->getRating() . "</strong>
                </div>
                <div class='span4'>
                    <em>". $this->review->getDate() . "</em>
                </div>
            </div>";
        if ($full) {
             $str .= $this->review->getText();
        } else {
            $str .= substr($this->review->getText(), 0, 40);

        $str .= "<br>
            <a class='btn btn-info' href='index.php?page=review&rno=" . $this->review->getRid() . "'>See full</a>";
        }
        $str .= "</div>";

        return $str;
    }

}