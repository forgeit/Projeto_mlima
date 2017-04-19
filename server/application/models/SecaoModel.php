<?php

class SecaoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'secao';
	}	

	function findItens($idSecao) {
		$query = $this->db->query(
			"SELECT i.* " .
			"FROM secao_item si " .
			"JOIN item i ON i.id = si.id_item " .
			"WHERE si.id_secao = ? ", 
			array($idSecao)
			);
		return $query->result_array();
	}

	function insertItem($idSecao, $idItem) {
		$result = $this->db->query("INSERT INTO secao_item (id_secao, id_item) VALUES (?, ?)", array($idSecao, $idItem));		
        self::printError();
        return $result;
	}

	function deleteItens($idSecao) {
		$this->db->query('DELETE FROM secao_item WHERE id_secao = ?', array($idSecao));
		return true;
	}

	function getValidation() {
		return array(
			);
	}
}