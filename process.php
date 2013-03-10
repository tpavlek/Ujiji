<?php
session_start();
require_once('page.php');
$page = new Page($_SESSION['db_url'], $_SESSION['db_user'], $_SESSION['db_pass']);

$dbInstance = $page->getDB();

if (!isset($_GET)) {
    print "You must pass arguments in.";
    die();
}

switch($_GET['type']) {
    case 'user':
        switch($_GET['method']) {
            case 'register': $dbInstance->addUser($_POST['name'], $_POST['email'], $_POST['pass']);
                echo "You're registered, login now";
                print "<br><a href='index.php'>Go Home</a>";
            break;
            case 'login': $result = $dbInstance->login($_POST['email'], $_POST['pass']);
                  if ($result) {
                    $page->login($result['NAME'], $result['EMAIL']);
                    print "Logged in";
                      print "<br><a href='index.php'>Go Home</a>";
                } else {
                    print "Login information incorrect";
                      print "<br><a href='index.php'>Go Home</a>";
                    die();
                } break;
        }
    break;
    case 'ad':
        if (!isset($_POST['ads'])) {
            echo "You didn't check any ads";
            echo "<a href='index.php'>Go home</a>";
            die();
        }
        switch($_POST['method']) {
            case 'delete':
                foreach ($_POST['ads'] as $aid) {
                    $dbInstance->deleteAd($aid);
                }

                echo "Ads deleted";
                echo "<a href='index.php'>Go home</a>";
                break;
            case 'promote':
                foreach ($_POST['ads'] as $aid) {
                    $dbInstance->promoteAd($aid, $_POST['ono']);
                }
                echo "Ads promoted";
                echo "<a href='index.php'>Go home</a>";
                break;
        }
    break;
    case 'review':
        switch($_GET['method']) {
            case 'create':
                if($dbInstance->addReview($_POST['email'], $_SESSION['email'], $_POST['rating'], $_POST['review_text'])) {
                    print "Review added";
                    print "<a href='index.php'>Go home</a>";
                    die();
                }
            break;
        }
    break;
    case 'post':
        switch($_GET['method']) {
            case 'create':
                if($dbInstance->addAd($_POST['atype'], $_POST['title'], $_POST['price'], $_POST['description'],
                        $_POST['location'], $_SESSION['email'], $_POST['cat'])) {
                    print "Ad created";
                    print "<a href='index.php'>Go Home</a>";
                    die();

                }
        }
}



?>

