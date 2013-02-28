<?php
class Offer extends Page {

	private $ono;
	private $num_days;
	private $price;

	public function __construct($ono) {
		$data = $this->db->getOffer($ono);
		$this->ono = $ono;
		$this->num_days = $data['ndays'];
		$this->price = $data['price'];
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
