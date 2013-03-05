<?php
require_once('db.php');

class Page {

	protected $db;

	public function __construct($url, $user, $pass) {
		$this->db = new DB($url, $user, $pass);
	}

    function getDB() {
        return $this->db;
    }
}

?>
