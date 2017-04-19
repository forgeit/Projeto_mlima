<?php

class PacoteModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'pacote';
	}	

	function findSecoes($idPacote) {
		$query = $this->db->query(
			"SELECT s.* " .
			"FROM pacote_secao pi " .
			"JOIN secao s ON s.id = pi.id_secao " .
			"WHERE pi.id_pacote = ? ", 
			array($idPacote)
			);
		return $query->result_array();
	}

	function insertSecao($idPacote, $idSecao) {
		$result = $this->db->query("INSERT INTO pacote_secao (id_pacote, id_secao) VALUES (?, ?)", array($idPacote, $idSecao));		
		self::printError();
		return $result;
	}

	function deleteSecoes($idPacote) {
		$this->db->query('DELETE FROM pacote_secao WHERE id_pacote = ?', array($idPacote));
		return true;
	}	

	function getValidation() {
		return array(
			'titulo' => array('Título', 'string', '255', true),
			'duracao_festa' => array('Duração da Festa', 'string', '45', false)
			);
	}
}