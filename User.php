<?php

class User extends Page{

	private $name;
	private $email;
	private $last_login;

	public function __construct($email) {
		$data = $this->db->getUser($email);
		$this->name = $data['name'];
		$this->email = $data['email'];
		$this->last_login = $data['last_login'];
	}

	function getName() {
		return $this->name;
	}

	function getEmail() {
		return $this->email;
	}

	function getLastLogin() {
		return $this->last_login;
	}
}

?>
