<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "14/08/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "18/08/2018",
		"VERSION":"0.0.2"
	}
*/
class Index {

	public $_func;

	private $_cor;

	private $_push = false;

	private $_url;

	private $_lang;

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_cor = new Model_GOD;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}

		$this->_url = $this->_cor->getUrl();

		$this->_lang = $this->_cor->getLang();
	}

	function index(){

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('index', 'index'), $mustache);

		}else{

			echo $this->_cor->push('index', 'index', $mustache);
		}
	}
}