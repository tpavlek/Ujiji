<?php
require_once('fragments/Review.php');
/**
 * Created by JetBrains PhpStorm.
 * User: ebon
 * Date: 08/03/13
 * Time: 14:47
 * To change this template use File | Settings | File Templates.
 */

$pageNum = (isset($_GET['pageNum'])) ? $_GET['pageNum'] : 0;
$reviews = $page->getDB()->getReviewsSinceLastLogin($_SESSION['email'], $pageNum);

if (!$reviews) {
    print "No " . (($pageNum > 0) ? "more " : "") . "reviews to show";
} else {

    foreach ($reviews as $rev) {
        $fragment = new ReviewFragment($rev);
        print $fragment->getBox();
    }

    if (count($reviews) == 3) {
        echo "<a class='btn btn-primary' href='index.php?page=user&pageNum=" . $pageNum + 1 . "'>Next Page</a>";
    }
}


?>



