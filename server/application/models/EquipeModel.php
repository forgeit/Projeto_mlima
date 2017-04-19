<?php

class EquipeModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'equipe';
	}	

	function getValidation() {
		return array(
				'titulo' => array('Título', 'string', '255', true)
			);
	}
}