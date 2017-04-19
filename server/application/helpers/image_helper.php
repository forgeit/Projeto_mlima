<?php

define('MAX_IMG_SIZE', 1.05); //Mb
define('MIN_IMG_SIZE_CHANGE_QUALITY', 0.4); //Mb
define('QUALITY_TO_CHANGE', 75);
define('SIZE_CONVERSION', 0.000001);

define('URL_IMG', FCPATH.'images/');


class ImageHelper {
	

	/**
	*	Converte arquivos em $_FILES['uploads'] para um array de arquivos
	*/
	public static function filesToArray() {
		$arrFiles = array();
		for ($x = 0; $x<count($_FILES['uploads']['name']); $x++) {
			$arrFiles[$x] = array(
				'name' => $_FILES['uploads']['name'][$x],
				'type' => $_FILES['uploads']['type'][$x],
				'tmp_name' => $_FILES['uploads']['tmp_name'][$x],
				'error' => $_FILES['uploads']['error'][$x],
				'size' => $_FILES['uploads']['size'][$x]
				);

		}
		return $arrFiles;
	}

	/**
	*	Verifica o tamanho e o tipo de imagens
	*/
	public static function checkImage($arrFiles) {
		foreach ($arrFiles as $img) {
			if ($img['size'] * SIZE_CONVERSION > MAX_IMG_SIZE) {
				return false;
			}
			if ($img['type'] !== 'image/jpeg') {
				return false;
			}
		}
		return true;
	}

	/**
	*	Cria as pastas de imagens
	*/
	public static function createFolders($module) {
		if (!file_exists(URL_IMG)) {
			mkdir(URL_IMG, 0700);
		}
		if (!file_exists(URL_IMG.$module)) {
			mkdir(URL_IMG.$module);
		}
	}

	/**
	*	Conferte um array de arquivos em um array de ArquivoModel
	*/
	public static function filesToArquivoModel($files, $module) {
		$arrImg = array();
		for ($x = 0; $x<count($files); $x++) {
			$arrImg[$x]['nome'] = $files[$x]['name'];
			$arrImg[$x]['type'] = $files[$x]['type'];
			$arrImg[$x]['modulo'] = $module;
		}
		return $arrImg;
	}

	/**
	*	move o arquivo para o local correto
	*/
	public static function saveArchive($module, $file, $idImage) {
		$path = URL_IMG.$module.'/' . $idImage . '.jpg';
		if ($file['size'] * SIZE_CONVERSION > MIN_IMG_SIZE_CHANGE_QUALITY) {
			//open a stream for the uploaded image
			$streamHandle = @fopen($file['tmp_name'], 'r');
    		//create a image resource from the contents of the uploaded image
			$resource = imagecreatefromstring(stream_get_contents($streamHandle));

			if(!$resource) {
				return false;
			}

    		//close our file stream
			@fclose($streamHandle);

    		//move the uploaded file with a lesser quality
			imagejpeg($resource, $path, QUALITY_TO_CHANGE); 
    		//delete the temporary upload
			@unlink($upload['tmp_name']);
		} else {
			move_uploaded_file($file['tmp_name'], $path);
		}

		return $path;
	}

	public static function deleteFile($path) {
		if(file_exists($path)){
			unlink($path);
		}
	}

} 