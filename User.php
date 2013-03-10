<?php

class User extends Page{

	private $name;
	private $email;
	private $last_login;

	public function __construct($email, $db = FALSE) {
        if ($db) {
            $data = $db->getUser($email);
        } else {
            parent::__construct($_SESSION['db_url'], $_SESSION['db_user'], $_SESSION['db_pass']);
		    $data = $this->db->getUser($email);
        }
		$this->name = $data['NAME'];
		$this->email = $email;
		$this->last_login = $data['LAST_LOGIN'];
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
