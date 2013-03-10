<?php
require_once('Review.php');
require_once('fragments/Review.php');
/**
 * Created by JetBrains PhpStorm.
 * User: ebon
 * Date: 09/03/13
 * Time: 11:03
 * To change this template use File | Settings | File Templates.
 */
if (!isset($_GET['rno'])) {
    print "You must input an rno<br>";
    print "<a href='index.php'>Go home</a>";
    die();
}

$review = new Review($_GET['rno']);
$fragment = new ReviewFragment($review);

print $fragment->getBox(true);
?>