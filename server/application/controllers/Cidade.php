<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidade extends MY_Controller {

	public function findAll() {
		if (!$this->isActive()) {
			return;
		}
		$this->printReturn(RET_OK, $this->CidadeModel->findAll());		
	}	
}