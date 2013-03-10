<?php
require_once('db.php');

class Page {

	protected $db;
  public $date;

	public function __construct($url, $user, $pass) {
		$this->db = new DB($url, $user, $pass);
    date_default_timezone_set("America/Edmonton");
    $this->date = date("d-m-y");
	}

    function getDB() {
        return $this->db;
    }

  function getDate() {
    return $this->date;
  }
    function login($name, $email) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

    }

    function logout() {
        $this->db->logout($_SESSION['email']);
        session_unset();
        session_destroy();
    }
}

?>
