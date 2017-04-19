<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MY_Controller {

	public function login() {
		if (!$this->isActive()) {
			return;
		}

		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);
		if (!$data) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(13));
			return;
		}

		if (!$object->login || !$object->senha) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(14));
			return;
		}

		$user = $this->UsuarioModel->findByLoginAndSenha($object->login, $object->senha);
		if ($user) {
			$jwt = JWT::encodeWithTime($user['nome'], $user['login']);			
			$this->printReturn(RET_OK, array('usuario'=>$user, 'jwt'=>$jwt));		
		} else {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(14));
		}
		
	}

	public function update() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$object = json_decode($data);

		if (!$object->login || !$object->oldPassword || !$object->newPassword || !$object->newPasswordAgain) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(15));
			return;
		}
	
		if ($object->newPassword !== $object->newPasswordAgain) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(16));
			return;
		}

		$user = $this->UsuarioModel->findByLoginAndSenha($object->login, $object->oldPassword);
		if (!$user) {
			$this->printReturn(RET_ERROR, null, Helper::getMessage(14));
			return;
		}

		$user['senha'] = $object->newPassword;
		$object = (object) $user;

		if ($this->checkExec(array('exec' => $this->UsuarioModel->update($user['id'], $user)))) {	
			$this->printReturn(RET_OK, $object->id, Helper::getMessage(0));
		}
	}
}