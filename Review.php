<?php

class Review extends Page {

	private $rid;
	private $rating;
	private $text;
	private $author;
	private $reviewee;
	private $post_date;

	public function __construct($rid) {
		$data = $this->db->getReview($rid);
		$this->rid = $rid;
		$this->rating = $data['rating'];
		$this->text = $data['text'];
		$this->author = $data['reviewer'];
		$this->reviewee = $data['reviewee'];
		$this->post_date = $data['rdate'];
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
