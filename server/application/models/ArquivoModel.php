<?php

class ArquivoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'arquivo';
	}		

	/**
	* 	Deleta o arquivo pelo ID e remove também o arquivo físico
	*/
	function deleteArquivo($id) {
		$object = $this->findById($id);
		if ($object) {
			$filePath = $object['caminho'];
			ImageHelper::deleteFile($filePath);
			$this->remove($id);
		}
	}
}