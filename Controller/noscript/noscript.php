<?
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

	function __construct(){

		$this->_cor = new Model_GOD;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}
	}

	function index(){

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('noscript', 'noscript', 'login'), $mustache);

		}else{

			echo $this->_cor->push('noscript', 'noscript', $mustache);
		}
	}
}