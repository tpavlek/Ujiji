<?php
class Offer extends Page {

	private $ono;
	private $num_days;
	private $price;

	public function __construct($ono) {
        parent::__construct($_SESSION['db_url'], $_SESSION['db_user'], $_SESSION['db_pass']);
		$data = $this->db->getOffer($ono);
		$this->ono = $ono;
		$this->num_days = $data['NDAYS'];
		$this->price = $data['PRICE'];
	}

	function getOno() {
		return $this->ono;
	}

	function getNumDays() {
		return $this->num_days;
	}

	function getPrice() {
		return $this->price;
	}
}
?>
