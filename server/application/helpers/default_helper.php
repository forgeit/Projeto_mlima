<?php

class Helper {
	

	public static function inputValidation($object, $validations) {
		$arr = (array)$object;

		foreach ($validations as $key => $value) {			
			if ($value[3] && self::isNullOrEmpty($arr[$key])) { //Required
				return self::getMessage(20, $value[0]);
			}
			if ($value[2] &&  $arr[$key] && strlen($arr[$key]) > $value[2]) {
				return self::getMessage(21, $value[0]);
			} 
			if ($value[1] &&  $arr[$key] && !self::typeValid($value[1], $arr[$key])) {
				return self::getMessage(22, $value[0]);
			}
		}

		return OK;
	}

	public static function isNullOrEmpty($value) {
		return !$value || $value === '' || is_null($value);			
	}

	public static function typeValid($type, $data) {
		if ($type == 'cpf' && !self::checkCPF($data)) {
			return false;
		}
		if ($type == 'email' && !self::checkEmail($data)) {
			return false;
		}
		if ($type == 'int' && !is_numeric($data)) { 
			return false;
		}
		if ($type == 'date') {
			return self::is_valid_date($data);			
		}
		return true;
	}

	public static function strDatetoDate($str) {
		$data_exploded = explode('/', $str);
		return $data_exploded[2].'-'.$data_exploded[1].'-'.$data_exploded[0];
	}

	public static function dateToStr($date) {
		return date('d/m/Y', strtotime($date));
	}

	public static function getMessage($cod, $field = null) {
		switch($cod) {
			case 0:
			return "Registro Salvo";
			break;
			case 1:
			return "Registro Excluído";
			break;
			case 2:
			return "Orçamento Enviado";
			break;
			case 3:
			return "Obrigado pelo contato, responderemos assim que possível";
			break;

			case 10: 
			return "Erro ao Salvar os Dados";						
			break;
			case 11:
			return "Imagens devem ser de no máximo 1Mb e no formato jpg/jpeg";
			break;
			case 12:
			return "Erro ao salvar os arquivos";
			break;
			case 13: 
			return "Erro ao efetuar o Login";
			break;
			case 14: 
			return "Usuário e/ou Senha inválido(s)";
			break;
			case 15:
			return "Preencha os campos";
			break;
			case 16:
			return "Senhas não conferem";
			break;
			case 17:
			return "Registro não pode ser excluído, está sendo utilizado";
			break;
			case 18:
			return "Email já cadastrado";
			break;

			case 20:
			return $field.' é Obrigatório';
			break;
			case 21:
			return $field.' muito Longo';
			break;
			case 22:
			return $field.' Inválido(a)';
			break;
		} 
	}

	public static function is_valid_date($value, $format = 'dd/mm/yyyy'){ 
		if(strlen($value) >= 6 && strlen($format) == 10){ 

	        // find separator. Remove all other characters from $format 
			$separator_only = str_replace(array('m','d','y'),'', $format); 
	        $separator = $separator_only[0]; // separator is first character 
	        
	        if($separator && strlen($separator_only) == 2){ 
	            // make regex 
	        	$regexp = str_replace('mm', '(0?[1-9]|1[0-2])', $format); 
	        	$regexp = str_replace('dd', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp); 
	        	$regexp = str_replace('yyyy', '(19|20)?[0-9][0-9]', $regexp); 
	        	$regexp = str_replace($separator, "\\" . $separator, $regexp); 
	        	if($regexp != $value && preg_match('/'.$regexp.'\z/', $value)){ 

	                // check date 
	        		$arr=explode($separator,$value); 
	        		$day=$arr[0]; 
	        		$month=$arr[1]; 
	        		$year=$arr[2]; 
	        		if(@checkdate($month, $day, $year)) 
	        			return true; 
	        	} 
	        } 
	    } 
	    return false; 
	} 

	public static function checkCPF($cpf) {		 
    	// Elimina possivel mascara
		$cpf = str_replace(".", "", $cpf);
		$cpf = str_replace("-", "", $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

    	// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf) != 11) {
			return false;
		}
    	// Verifica se nenhuma das sequências invalidas abaixo 
    	// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
			return false;
     		// Calcula os digitos verificadores para verificar se o
     		// CPF é válido
		} else {  

			for ($t = 9; $t < 11; $t++) {

				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}

			return true;
		}
	}

	public static function checkEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			list($alias, $domain) = explode("@", $email);
			if (checkdnsrr($domain, "MX")) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function sendMail($mailTo, $mailFrom, $subject, $message) {

		$message = wordwrap($message, 70, "\r\n");

		mail($mailTo, $subject, $message);

	}

}