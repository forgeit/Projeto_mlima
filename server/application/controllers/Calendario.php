<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario extends MY_Controller {

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

		$valid =  Helper::inputValidation($object, $this->CalendarioModel->getValidation());
		if ($this->checkValidation($valid)) {
			$object->data_ini = Helper::strDatetoDate($object->data_ini);
			if ($object->data_fim) {
				$object->data_fim = Helper::strDatetoDate($object->data_fim);
			} else {
				$object->data_fim = null;
			}
			if ($this->checkExec(array('exec' => $this->CalendarioModel->update($object->id, $object)))) {	
				$response = array('exec' => $this->CalendarioModel->update($object->id, $object));
				$this->printReturn(RET_OK, $object, Helper::getMessage(0));
			}
		}
	}

	public function find() {
		if (!$this->isActive()) {
			return;
		}

		print_r(json_encode($this->CalendarioModel->findById($this->uri->segment(3))));
	}

	public function findAll() {
		if (!$this->isActive()) {
			return;
		}
		$this->printReturn(RET_OK, $this->CalendarioModel->findAll());		
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
		
		$valid =  Helper::inputValidation($object, $this->CalendarioModel->getValidation());
		if ($this->checkValidation($valid)) {
			$object->data_ini = Helper::strDatetoDate($object->data_ini);
			if ($object->data_fim) {
				$object->data_fim = Helper::strDatetoDate($object->data_fim);
			} else {
				$object->data_fim = null;
			}
			if ($this->checkExec(array('exec' => $this->CalendarioModel->save($object)))) {			
				$this->printReturn(RET_OK, $this->CalendarioModel->findById($this->CalendarioModel->getLastInsertedId()), Helper::getMessage(0));
			}
		}		
	}

	public function remove() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->CalendarioModel->findById($this->uri->segment(3));		
		if ($this->checkExec(array('exec' => $this->CalendarioModel->remove($this->uri->segment(3))))) {			
			$this->printReturn(RET_OK, null, Helper::getMessage(1));	
		}
		
	}
}