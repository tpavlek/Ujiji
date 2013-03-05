<?php

$dbInstance = $page->getDB();

if (!isset($_GET)) {
    print "You must pass arguments in.";
    die();
}

switch($_GET['type']) {
    case 'user':
        switch($_GET['method']) {
            case 'register': $dbInstance->addUser($_POST['name'], $_POST['email'], $_POST['pass']); break;
            case 'login': if($dbInstance->login($_POST['email'], $_POST['pass'])) {
                $page->login($_POST['name'], $_POST['email']);
            } else {
                print "Login information incorrect";
                die();
            } break;
        }
    break;
}

?>