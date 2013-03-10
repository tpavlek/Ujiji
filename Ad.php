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

    /**
     * We do a bit of clever passing here to avoid oracle user session limits.
     * Normally on search we'd be instantiating a bunch of these classes quickly and filling out an array of objects
     * Unfortunately Oracle will stop us from doing this. In most cases it works fine, but in the case of search,
     * we need more connections so I'll pass a copy of db to this function in those specific cases
     */
    public function __construct($aid, $db = FALSE) {
        if ($db) {
            $data = $db->getAd($aid);
        } else {
            parent::__construct($_SESSION['db_url'], $_SESSION['db_user'], $_SESSION['db_pass']);
            $data = $this->db->getAd($aid);
        }
		$this->aid = $aid;
        $this->type = $data['ATYPE'];
		$this->title = $data['TITLE'];
		$this->price = $data['PRICE'];
		$this->desc = $data['DESCR'];
		$this->location = $data['LOCATION'];
		$this->post_date = $data['PDATE'];
		$this->author = $data['POSTER'];
		$this->category = $data['CAT'];
	}

	function getAid() {
		return $this->aid;
	}

    function getType() {
        return $this->type;
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
