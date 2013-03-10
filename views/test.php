<?php
require_once('User.php');
//$user = new User('ferdinand@hb.com', $page->getDB());
/*print_r($user);
print_r($user->getName());*/
//print_r($page->getDB()->getUser('bob@ujiji.com'));

/*$database_conn = $page->getDB()->getPDO();
$email = 'iron@habsburg.com';
$query = "SELECT avg(reviews.rating) as AVG
            FROM reviews
            WHERE reviewee = :email";
$queryPrepared = $database_conn->prepare($query);
$queryPrepared->bindValue(':email', $email);
$queryPrepared->execute();
print_r($queryPrepared->fetch());*/

/*$result = $page->getDB()->getCategories();

print_r($result);

foreach($result as $key => $value) {
    if (empty($value)) {
        print $key;
    }
}

/*$topLevelCategories = array();
foreach ($result as $key => $cat) {
    if (!isset($cat['SUPERCAT'])) {
        $topLevelCategories[] = $cat['CAT'];
        unset($result[$key]);
    }
}

while ($result) {

    foreach($result as $key => $cat) {
        if (in_array($cat['SUPERCAT'], $topLevelCategories)) {
            $topLevelCategories[$cat['SUPERCAT']][] = $cat['CAT'];
            unset($result[$key]);
        }
    }
}



/*foreach ($result as $cat) {
    print($cat);
}*/

print_r($page->getDB()->getAvgRating('anna@pof.com'));

?>



