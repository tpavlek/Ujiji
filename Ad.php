<?php

class Ad extends Page {

	private $aid;
	private $type;
	private $title;
	private $price;
	private $desc;
	private $location;
	private $post_date;
	private $author;
	private $category;

	public function __construct($aid) {
		$data = $this->db->getAd($aid);
		$this->aid = $data['aid'];
		$this->title = $data['title'];
		$this->price = $data['price'];
		$this->desc = $data['descr'];
		$this->location = $data['location'];
		$this->post_date = $data['pdate'];
		$this->author = $data['poster'];
		$this->category = $data['cat'];
	}

	function getAid() {
		return $this->aid;
	}

	function getTitle() {
		return $this->title;
	}

	function getPrice() {
		return $this->price;
	}

	function getDesc() {
		return $this->desc;
	}

	function getLocation() {
		return $this->location;
	}

	function getDate() {
		return $this->post_date;
	}

	function getAuthor() {
		return $this->author;
	}

	function getCategory() {
		return $this->category;
	}

}

?>
