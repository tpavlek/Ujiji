<?php

/** Primary DB abstratction class. Each function within should map, relatively
 * to some controller, which is then used in views for rendering. Thus
 * this is the equivalent of a model in MVC. The structure will be with
 * heavy models, so all the bulk of the application logic will be within.
 */

class DB {

    private $database_conn;


    /** the constructor instantiates a new databse connection using
     * PDO.
     */

    public function __construct($url, $user, $password) {
        $this->database_conn = new PDO($url, $user, $password);
    }

    function getPDO() {
        return $this->database_conn;
    }

    /** Takes a string 'type' and from that checks, contextually, whether value already exists in table
     * types = 'username'
     * 		'email'
     * 		...
     * 		etc
     * returns true/false
     */


    function isInDatabase($type, $value) {

        switch ($type) {
            case "user":
                $query = "SELECT name from users where email = '". $value ."'";
                $queryPrepared = $this->database_conn->query($query);
                return ($queryPrepared->fetch());
            break;

        }

        return true;

    }

    /** Searches for the keywords in both title and description
     * $page starts at index 0 and increases by increments of $PAGE_SIZE
     * results are ordered by date, newest first
     * Returns a sorted array of Ad objects
     */

    function adSearch($keyword, $page, $PAGE_SIZE = 5) {
        require_once('Ad.php');
        $query = "SELECT aid from ads
              where ";
        for ($i = 0; $i < count($keyword); $i++) {
            $add = "(lower(title) LIKE '%" . strtolower($keyword[$i]) . "%'
                OR lower(descr) LIKE '%" . strtolower($keyword[$i]) . "%')";
            if ($i < count($keyword) -1) {
                $add .= " OR ";
            }
            $query .= $add;
        }
        $query .= " ORDER BY pdate DESC";

        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->execute();
        $resultSet = $queryPrepared->fetchAll();
        $returnArray = array();

        for ($j = $page * $PAGE_SIZE; ($j < ($page * $PAGE_SIZE) + $PAGE_SIZE) && $j < count($resultSet); $j++) {
            $returnArray[] = new Ad($resultSet[$j]['AID'], $this);
        }

        return($returnArray);
    }

    function userSearch($name, $page, $PAGE_SIZE = 5) {
        require_once('User.php');

        $query = "SELECT email from users
            where lower(name) LIKE '%". strtolower($name) . "%'
            ORDER by name DESC";
        $queryPrepared = $this->database_conn->prepare($query);
        //$queryPrepared->bindValue(':name', $name);
        $queryPrepared->execute();
        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();

        for ($j = $page * $PAGE_SIZE; ($j < ($page * $PAGE_SIZE) + $PAGE_SIZE) && $j < count($resultSet); $j++) {
            $returnArray[] = new User($resultSet[$j]['EMAIL'], $this);
        }

        return $returnArray;

    }

    /** Returns array of ad objects based on the user ID that posted it
     *
     */

    function getUserAds($email, $page, $PAGE_SIZE = 5) {
        require_once('Ad.php');
        $query = "SELECT aid from ads where poster = :email ORDER BY pdate DESC";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();

        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();

        for ($j = $page * $PAGE_SIZE; ($j < ($page * $PAGE_SIZE) + $PAGE_SIZE) && $j < count($resultSet); $j++) {
            $returnArray[] = new Ad($resultSet[$j]['AID']);
        }

        return($returnArray);
    }

    /**
     * Returns true/false based on success
     */

    function deleteAd($aid) {
        $query = "DELETE from purchases where aid = :aid";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':aid', $aid);
        $queryPrepared->execute();
        $query = "DELETE from ads where aid = :aid";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':aid', $aid);
        return $queryPrepared->execute();
    }

    /** returns a list of offer objects
     */
    function getOffers() {
        require_once('Offer.php');
        $query = "SELECT ono from offers";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->execute();
        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();


        foreach ($resultSet as $row) {
            $returnArray[] = new Offer($row['ONO']);
        }

        return $returnArray;
    }

    function getOffer($ono) {
        $query = "SELECT ndays, price from offers where ono = :ono";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':ono', $ono);
        $queryPrepared->execute();
        return $queryPrepared->fetch();
    }


    function promoteAd($aid, $offer) {
        $query = "INSERT into purchases values(
            (SELECT 'p' || to_char(to_number(substr(max(pur_id), 2)) +1) from purchases),
            SYSDATE, :aid, :ono)";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':aid', $aid);
        $queryPrepared->bindValue(':ono', $offer);
        $queryPrepared->execute();
    }

    /** Returns data to fill a User object.
     * Only relevant fields are name, email, last_login
     */

    function getUser($email) {
        $query = "SELECT name, last_login FROM users WHERE email = '" . $email . "'";
        $queryPrepared = $this->database_conn->prepare($query);
        //$queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();
        $result = $queryPrepared->fetch();
        $queryPrepared->closeCursor();
        return $result;
    }

    function getNumberOfAds($email) {
        $query = "SELECT count(*) as NUM_ADS from ads where poster = :email";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();
        return($queryPrepared->fetch()['NUM_ADS']);
    }

    function getUsersByName($name) {
        require_once('User.php');

        $query = "SELECT email from users where lower(name) LIKE '%:name%'";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':name', strtolower($name));
        $queryPrepared->execute();

        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();

        foreach ($resultSet as $row) {
            $returnArray[] = new User($row['EMAIL']);
        }

        return ($resultSet);
    }

    function getReview($rno) {
        $query = "SELECT rno, rating, text, reviewer, reviewee, rdate
				FROM reviews
				WHERE rno = :rno";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':rno', $rno);
        $queryPrepared->execute();
        //print_r($queryPrepared->errorInfo());
        return $queryPrepared->fetch();
    }

    function getReviewsByReviewee($email) {
        require_once('Review.php');
        $query = "SELECT rno
					FROM reviews
					WHERE reviewee = '". $email . "'";
        $queryPrepared = $this->database_conn->prepare($query);
        //$queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();

        $resultSet = $queryPrepared->fetchAll();
        $returnArray = array();

        foreach ($resultSet as $row) {
            $returnArray[] = new Review($row['RNO']);
        }

        return $returnArray;
	}

    function getReviewsByReviewer($email) {
        $query = "SELECT rno
					FROM reviews
					WHERE reviewer = :email";
        $queryPrepared = $this->database_conn->prepare($query);
		$queryPrepared->bindValue(':email', $email);
		$queryPrepared->execute();
        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();

        foreach ($resultSet as $row) {
            $returnArray[] = new Review($row['RNO']);
        }

		return $returnArray;
	}

    /** Adds a review with the appropriate data.
     * Before adding, it will find the maximum ID and increment it by one
     */

    function addReview($reviewee, $reviewer, $rating, $text) {
        $query = "INSERT INTO reviews (rno, rating, text, reviewer, reviewee, rdate)
            VALUES (
                (SELECT (max(rno) + 1) from reviews),
                :rating,
                :text,
                :reviewer,
                :reviewee,
                SYSDATE
                )";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':rating', $rating);
        $queryPrepared->bindValue(':text', $text);
        $queryPrepared->bindValue(':reviewer', $reviewer);
        $queryPrepared->bindValue(':reviewee', $reviewee);
        $result = $queryPrepared->execute();
        //print_r($queryPrepared->errorInfo());
        return $result;

    }

    /** Creates a new ad
     * aid is set automatically by selecting the max of the aid column and incrementing by one
     */

    function addAd($type, $title, $price, $desc, $location, $author, $cat) {

        $query = "INSERT into ads (aid, atype, title, price, descr, location, pdate, poster, cat)
            VALUES (
                (SELECT 'a' || to_char(to_number(substr(max(aid), 2) +1)) from ads),
                :atype,
                :title,
                :price,
                :descr,
                :location,
                SYSDATE,
                :poster,
                :cat
            )";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':atype', $type);
        $queryPrepared->bindValue(':title', $title);
        $queryPrepared->bindValue(':descr', $desc);
        $queryPrepared->bindValue(':price', $price);
        $queryPrepared->bindValue(':location', $location);
        $queryPrepared->bindValue(':poster', $author);
        $queryPrepared->bindValue(':cat', $cat);
        $result = $queryPrepared->execute();
        //print_r($queryPrepared->errorInfo());
        return $result;

    }

    function getAd($aid) {
        $query = "SELECT atype, title, price, descr, location, pdate, poster, cat from ads
            WHERE aid = :aid";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':aid', $aid);
        $queryPrepared->execute();
        return $queryPrepared->fetch();

    }

    /**
     * TODO find all possible ad types?
     * returns array of ad types (strings)
     */

    function getAdTypes() {
        return array('W', 'S');
    }

    /** Returns an array of arrays - each category is an array and each subcategory is
     *  an array within.
     * Cyclical categories WILL cause an infinite loop, and nesting is only one-level deep with this implementation
     */
    function getCategories() {
        $query = "SELECT * from categories";
        $queryPrepared = $this->database_conn->query($query);
        $result = $queryPrepared->fetchAll();

        $topLevelCategories = array();
        foreach ($result as $key => $cat) {
            if (!isset($cat['SUPERCAT'])) {
                $topLevelCategories[$cat['CAT']] = array();
                unset($result[$key]);
            }
        }

        while ($result) {

            foreach($result as $key => $cat) {
                if (array_key_exists($cat['SUPERCAT'], $topLevelCategories)) {
                    $topLevelCategories[$cat['SUPERCAT']][] = $cat['CAT'];
                    unset($result[$key]);
                }
            }
        }

        return $topLevelCategories;


    }


    function addUser($name, $email, $pass) {

        if ($this->isInDatabase("user", $email)) {
            return false;
        }

        $query = "INSERT into users (name, email, pwd) VALUES(
            :name,
            :email,
            :pass
            )";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':name', $name);
        $queryPrepared->bindValue(':email', $email);
        $queryPrepared->bindValue(':pass', $pass);
        return $queryPrepared->execute();

    }

    function login($email, $pass) {

        if (!$this->isInDatabase("user", $email)) {
            return false;
        }

        $query = "SELECT name, email FROM users where email = '" .$email . "' AND pwd = '" . $pass ."'";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->execute();
        return $queryPrepared->fetch(PDO::FETCH_ASSOC);
    }

    /** sets the last_login field of the selected user to current date
     */
    function logout($email) {
        $query = "UPDATE users set last_login = SYSDATE where email = :email";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':email', $email);
        return $queryPrepared->execute();
    }

    function getReviewsSinceLastLogin($email, $pageNum, $PAGE_SIZE = 5) {
        require_once('Review.php');
        $query = "SELECT rno
            FROM reviews, users
            where reviewee = users.email and users.email = '" . $email . "'
            AND users.last_login < reviews.rdate
            ORDER BY rdate DESC";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->execute();
        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();
        if ($resultSet) {
            for ($j = $pageNum * $PAGE_SIZE;
                 ($j < ($pageNum * $PAGE_SIZE) + $PAGE_SIZE) && $j < count($resultSet) -1 ; $j++) {
                $returnArray[] = new Review($resultSet[$j]['RNO']);
            }
        }

        return $returnArray;

    }

    function getAvgRating($email) {
        $query = "SELECT avg(rating) as AVG
            FROM reviews
            WHERE reviewee = '" .$email . "'";
        $queryPrepared = $this->database_conn->prepare($query);
        //$queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();
        return $queryPrepared->fetch()['AVG'];
    }

    /**
     * Takes an AID and if the ad is on promotion, returns the number of days remaining until the promotion ends
     * returns false otherwise
     */
    function isAdOnPromotion($aid) {
        $query = "SELECT round((purchases.start_date + offers.ndays) - SYSDATE) as days_remaining
            FROM purchases, offers
            WHERE purchases.ono = offers.ono AND (purchases.start_date + offers.ndays) > SYSDATE
            AND purchases.aid = :aid";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':aid', $aid);
        $queryPrepared->execute();

        return($queryPrepared->fetch()['DAYS_REMAINING']);

    }







}

?>
