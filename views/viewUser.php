<?php
require_once('User.php');
/**
 * Created by JetBrains PhpStorm.
 * User: ebon
 * Date: 09/03/13
 * Time: 15:28
 * To change this template use File | Settings | File Templates.
 */
if (!isset($_GET['email'])) {
    echo "You must specify an email";
    echo "<a href='index.php'> Go Home</a>";
}

$user = new User($_GET['email']);
$pageNum = (isset($_POST['pageNum'])) ? $_POST['pageNum'] : 0;
$numAds = $page->getDB()->getNumberOfAds($user->getEmail());
$avgRating = $page->getDB()->getAvgRating($user->getEmail());

?>

Name: <?php echo $user->getName(); ?><br>
Email: <?php echo $user->getEmail(); ?> <br>
Number of Ads: <?php echo $numAds; ?><br>
Avg Rating: <?php echo $page->getDB()->getAvgRating($user->getEmail()); ?> <br>
<?php if (!isset($_GET['showReviews'])) {
    ?>
<form action='index.php?page=viewUser&email=<?php echo $_GET['email']; ?>&showReviews=1' method="POST">
    <input type="submit" value="Show reviews" class='btn btn-info'
        <?php echo (!$avgRating) ? "disabled" : ""; ?>/>
</form>
<?php
} else {
    require_once('fragments/Review.php');
    $reviews = $page->getDB()->getReviewsByReviewee($user->getEmail());
    foreach ($reviews as $review) {
        $fragment = new ReviewFragment($review);
        print $fragment->getBox(true);
    }
}
    ?>

<a class='btn btn-large btn-block btn-success' href='index.php?page=createReview&email=<?php echo $user->getEmail(); ?>'>
  Write a review for this user
</a>



