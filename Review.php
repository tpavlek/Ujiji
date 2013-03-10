<?php

class Review extends Page {

	private $rid;
	private $rating;
	private $text;
	private $author;
	private $reviewee;
	private $post_date;

	public function __construct($rid) {
        parent::__construct($_SESSION['db_url'], $_SESSION['db_user'], $_SESSION['db_pass']);
		$data = $this->db->getReview($rid);
		$this->rid = $rid;
		$this->rating = $data['RATING'];
		$this->text = $data['TEXT'];
		$this->author = $data['REVIEWER'];
		$this->reviewee = $data['REVIEWEE'];
		$this->post_date = $data['RDATE'];
	}

	function getRid() {
		return $this->rid;
	}

	function getRating() {
		return $this->rating;
	}

	function getText() {
		return $this->text;
	}

	function getAuthor() {
		return $this->author;
	}

	function getReviewee() {
		return $this->reviewee;
	}

	function getDate() {
		return $this->post_date;
	}

}

?>
