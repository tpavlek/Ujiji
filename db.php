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
	
	}

	/** Searches for the keyword in both title and description
	 * $page starts at index 0 and increases by increments of $PAGE_SIZE
	 * results are ordered by date, newest first
	 * Returns a sorted array of Ad objects 
	*/

	function adSearch($keyword, $page, $PAGE_SIZE = 5) {
		require_once('Ad.php');

		return( array( new Ad()));
	}

	/** Returns ad object based on the user ID that posted it
	 * 
	 */

	function getUserAds($email, $page, $PAGE_SIZE = 5) {
		require_once('Ad.php');
	
	}

	function deleteAd($aid) {
	}

	/** returns a list of offer objects
	 */
	function getOffers() {
		require_once('Offers.php');

	}
	

	function promoteAd($aid, $date, $offer) {
	}
	
	/** Returns data to fill a User object.
	 * Only relevant fields are name, email, last_login
	 */

	function getUser($email) {
		require_once('User.php');

	}

	function getUsersByName($name) {
		require_once('User.php');

		return array(UserObjects);
	}

	function getReviewsByReviewee($email) {
	}

	function getReviewsByReviewer($email) {
	}

	/** Adds a review with the appropriate data.
	 * Before adding, it will find the maximum ID and increment it by one
	 */

	function addReview($reviewee, $reviewer, $date, $rating, $text) {
	}
	
	/** Creates a new ad
	 * aid is set automatically by selecting the max of the aid column and incrementing by one
	 */

	function addAd($type, $title, $price, $desc, $location, $date, $author, $cat) {
	}

	function getAd($aid) {
		require_once('Ad.php');
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

        //check if name is in database

        //check if email is in database

        //add user

    }

    function login($email, $pass) {
        // check if email is in db

        // check if pass is correct

        //return true/false
    }
	
	/** sets the last_login field of the selected user to current date
	 */
	function logout($email, $date) {
	}







}

?>
