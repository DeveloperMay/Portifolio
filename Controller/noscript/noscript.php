<?php
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "14/08/2018",
		"CONTROLADOR": "No Script",
		"LAST EDIT": "14/08/2018",
		"VERSION":"0.0.1"
	}
*/
class Noscript{

	public $_cor;

	private $_push = false;

	private $metas = array();

	function __construct(){

		$this->_cor = new Model_GOD;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}
	}

	function index(){

		$mustache = array();

		$this->metas['title'] = 'DevWeb - Precisa ativar o JavaScript';

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('noscript', 'noscript', 'login', $this->metas), $mustache);

		}else{

			echo $this->_cor->push('noscript', 'noscript', $mustache, $this->metas);
		}
	}
}