<?php
require_once('db.php');

class Page {

	private $db;

	public function __construct($url, $user, $pass) {
		$this->db = new DB($url, $user, $pass);
	}
}

?>
