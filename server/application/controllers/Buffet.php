<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buffet extends MY_Controller {

	public function update() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);
		unset($object->id_imagem);

		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}

		$valid =  Helper::inputValidation($object, $this->BuffetModel->getValidation());
		if ($this->checkValidation($valid) && $this->checkExec(array('exec' => $this->BuffetModel->update($object->id, $object)))) {	
			$response = array('exec' => $this->BuffetModel->update($object->id, $object));
			$this->printReturn(RET_OK, $object->id, Helper::getMessage(0));
		}
	}

	public function find() {
		if (!$this->isActive()) {
			return;
		}

		print_r(json_encode($this->BuffetModel->findById($this->uri->segment(3))));
	}

	public function findAll() {
		if (!$this->isActive()) {
			return;
		}
		$this->printReturn(RET_OK, $this->BuffetModel->findAll());		
	}

	public function insert() {
		if (!$this->isActive()) {
			return;
		}		

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);
		unset($object->id_imagem);
		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}
		
		$valid =  Helper::inputValidation($object, $this->BuffetModel->getValidation());
		if ($this->checkValidation($valid) && $this->checkExec(array('exec' => $this->BuffetModel->save($object)))) {			
			$this->printReturn(RET_OK, $this->BuffetModel->getLastInsertedId(), Helper::getMessage(0));
		}		
	}

	public function remove() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->BuffetModel->findById($this->uri->segment(3));		
		if ($this->checkExec(array('exec' => $this->BuffetModel->remove($this->uri->segment(3))))) {
			if ($data['id_imagem'] && $this->ArquivoModel->deleteArquivo($data['id_imagem'])) {
			}
			
			$this->printReturn(RET_OK, null, Helper::getMessage(1));	
		}
		
	}
}