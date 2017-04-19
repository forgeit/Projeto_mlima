<?php

class NewsletterModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'newsletter';
	}	

	function existEmail($email) {
		if(is_null($email)) {
			return false;
		}

		$this->db->where('email', $email);

		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}	

	function getValidation() {
		return array(
				'email' => array('Email', 'email', '255', true)
			);
	}
}