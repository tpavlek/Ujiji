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
                $query = "SELECT email from user where email = :email";
                $queryPrepared = $this->database_conn->prepare($query);
                $queryPrepared->bindValue(':email', $value);
                $queryPrepared->execute();
                return $queryPrepared->rowCount();
            break;

        }

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
            $add = "(title LIKE '%:keyword%' OR desc LIKE '%:keyword%')";
            if ($i == count($keyword) -1) {
                $add .= " OR ";
            }
            $query .= $add;
        }
        $query .= " ORDER BY pdate DESC";

        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->execute();
        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();

        for ($j = $page * $PAGE_SIZE; ($j <= ($page * $PAGE_SIZE) + $PAGE_SIZE) || $j <= count($resultSet); $j++) {
            $returnArray[] = new Ad($resultSet[$j]['aid']);
        }

        return($returnArray);
    }

    /** Returns array of ad objects based on the user ID that posted it
     *
     */

    function getUserAds($email, $page, $PAGE_SIZE = 5) {
        require_once('Ad.php');
        $query = "SELECT aid from ads where uid = :email ORDER BY pdate DESC";
        $queryPrepared = $this->pdo->prepare($query);
        $queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();

        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();

        for ($j = $page * $PAGE_SIZE; ($j <= ($page * $PAGE_SIZE) + $PAGE_SIZE) || $j <= count($resultSet); $j++) {
            $returnArray[] = new Ad($resultSet[$j]['aid']);
        }

        return($returnArray);
    }

    /**
     * Returns true/false based on success
     */

    function deleteAd($aid) {
        $query = "DELETE from ads where aid = :aid";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':aid', $aid);
        return $queryPrepared->execute();
    }

    /** returns a list of offer objects
     */
    function getOffers() {
        require_once('Offers.php');
        $query = "SELECT ono from offers";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->execute();
        $resultSet = $queryPrepared->fetchAll();

        $returnArray = array();

        foreach ($resultSet as $row) {
            $returnArray[] = new Offer($row['ono']);
        }

        return $returnArray;

    }


    function promoteAd($aid, $date, $offer) {
    }

    /** Returns data to fill a User object.
     * Only relevant fields are name, email, last_login
     */

    function getUser($email) {
        $query = "SELECT name, email, last_login
      FROM users
      WHERE email = :email";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();
        return $queryPrepared->fetch();
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
            $returnArray[] = new User($row['email']);
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
        return $queryPrepared->fetch();
    }

    function getReviewsByReviewee($email) {
        require_once('Review.php');
        $query = "SELECT rno
					FROM reviews
					WHERE reviewee = :email";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':email', $email);
        $queryPrepared->execute();

        $resultSet = $queryPrepared->fetchAll();
        $returnArray = array();

        foreach ($resultSet as $row) {
            $returnArray[] = new Review($row['rno']);
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
            $returnArray[] = new Review($row['rno']);
        }

		return $returnArray;
	}

    /** Adds a review with the appropriate data.
     * Before adding, it will find the maximum ID and increment it by one
     */

    function addReview($reviewee, $reviewer, $date, $rating, $text) {
        $query = "INSERT into reviews (rno, rating, text, reviewer, reviewee, rdate)
            VALUES (
                (SELECT (max(rno) + 1), from reviews),
                :rating,
                :text,
                :reviewer,
                :reviewee,
                :rdate)";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':rating', $rating);
        $queryPrepared->bindValue(':text', $text);
        $queryPrepared->bindValue(':reviewer', $reviewer);
        $queryPrepared->bindValue(':reviewee', $reviewee);
        $queryPrepared->bindValue(':date', $date);
        return ($queryPrepared->execute());

    }

    /** Creates a new ad
     * aid is set automatically by selecting the max of the aid column and incrementing by one
     */

    function addAd($type, $title, $price, $desc, $location, $date, $author, $cat) {
        $query = "INSERT into ads (aid, atype, title, price, descr, location, pdate, poster, cat)
            VALUES (
                (SELECT (max(aid) +1) from ads),
                :type,
                :title,
                :price,
                :desc,
                :location,
                :date,
                :poster,
                :cat
            )";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':type', $type);
        $queryPrepared->bindValue(':title', $title);
        $queryPrepared->bindValue(':desc', $desc);
        $queryPrepared->bindValue(':location', $location);
        $queryPrepared->bindValue(':date', $date);
        $queryPrepared->bindValue(':poster', $author);
        $queryPrepared->bindValue(':cat', $cat);
        $queryPrepared->execute();
    }

    function getAd($aid) {
        $query = "SELECT (atype, title, price, descr, location, pdate, poster, cat) from ads
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
        return array('Wanted', 'Offering');
    }

    /** Returns an array of arrays - each category is an array and each subcategory is
     *  an array within
     */
    function getCategories() {

    }


    function addUser($name, $email, $pass) {

        if ($this->isInDatabase("user", $email)) {
            return false;
        }

        $query = "INSERT into users (name, email, pass) VALUES(
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

        $query = "SELECT email from users where email = :email AND pwd = :pass";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':email', $email);
        $queryPrepared->bindValue(':pass', $pass);
        $queryPrepared->execute();
        return $queryPrepared->rowCount();
    }

    /** sets the last_login field of the selected user to current date
     */
    function logout($email, $date) {
        $query = "UPDATE table users set last_login = :date where email = :email";
        $queryPrepared = $this->database_conn->prepare($query);
        $queryPrepared->bindValue(':date', $date);
        $queryPrepared->bindValue(':email', $email);
        return $queryPrepared->execute();
    }







}

?>
