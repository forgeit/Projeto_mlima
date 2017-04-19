<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aniversariante extends MY_Controller {

	public function update() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$objectArr = json_decode($data);
		
		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(10));
			return;
		}

		foreach ($objectArr as $obj) {
			$valid = Helper::inputValidation($obj, $this->AniversarianteModel->getValidation());
			if (!$this->checkValidation($valid)) {
				return;
			}	
		}
		
		foreach ($objectArr as $obj) {
			$obj->dt_nasc = Helper::strDatetoDate($obj->dt_nasc);
			if ($obj->id) {
				if (!$this->checkExec(array('exec' => $this->AniversarianteModel->update($obj->id, $obj)))) {
					return;
				}
			} else {
				if (!$this->checkExec(array('exec' => $this->AniversarianteModel->save($obj)))) {
					return;
				}
			}
		}
		$this->printReturn(RET_OK, null, Helper::getMessage(0));
	}

	public function find() {
		if (!$this->isActive()) {
			return;
		}

		$list = $this->AniversarianteModel->findByIdCliente($this->uri->segment(3));
		for ($x=0;$x<count($list);$x++){
			$list[$x]['dt_nasc'] = Helper::dateToStr($list[$x]['dt_nasc']);
		}

		print_r(json_encode($list));
	}

	public function findAll() {
		return;	
	}

	public function insert() {
		return;
	}

	public function remove() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->AniversarianteModel->findById($this->uri->segment(3));		
		if ($this->checkExec(array('exec' => $this->AniversarianteModel->remove($this->uri->segment(3))))) {			
			$this->printReturn(RET_OK, null, Helper::getMessage(1));	
		}
		
	}
}