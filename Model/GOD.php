<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "14/08/2018",
	"MODEL": "GOD",
	"LAST EDIT": "18/08/2018",
	"VERSION":"0.0.2"
}
*/

class Model_God extends Model_Functions_Functions{


	public $_conexao;

	public $_eye;

	public $_layout;

	public $_url;

	public $url;

	/* Linguas que o site suporta */
	public $langs = array(
		'br' => '',
		'en' => 'en'
	);

	public $lang = '';

	function __construct($conexao = null){

		$url = $_SERVER['REQUEST_URI'];

		$this->url = explode('/', $url);

		foreach ($this->langs as $lang => $null){

			if(isset($this->url[1]) and $this->url[1] === $lang){
				// Remove 'Ignora' o langs (br, en, etc..)
				unset($this->url[1]);

				// Salva o leng atual, exp br
				$this->lang = $lang;
				$novaURL = implode('/', $this->url);
				$novaURL = explode('/', $novaURL);

				// AQUI, ignora a lang e remonta a url USAR ESSA PORRA, pro mvc funfa
				$this->url = $novaURL;
			}
		}

		if($conexao !== null){

			$this->_conexao = $conexao;

		}else{

			$conexao = new Model_Bancodados_Conexao;
			$this->_conexao = $conexao;
		}

		$this->_eye = new Model_View($this->lang);

		$this->_layout = new Model_Layout($this->_conexao);

		//new de($this->lang);
	}

	// Retorna URL já ignorando o lang
	function getUrl(){
		return $this->url;
	}

	// Retorna o lang atual
	function getLang(){
		return $this->lang;
	}

	function _layout($controlador, $visao, $template = LAYOUT){

		$this->_layout->setView($template);
		$this->_eye->setView($controlador, $visao);

		$mustache = array(
			'{{visao}}' => $this->_eye->visao()
		);		

		return $this->comprimeHTML(str_replace(array_keys($mustache), array_values($mustache), $this->_layout->Layout()));
	}

	function _visao($visao, $bigodim = null){

		if(is_array($bigodim) and $bigodim !== null and $bigodim !== ''){

			@$var = $this->comprimeHTML(str_replace(array_keys($bigodim), array_values($bigodim), $visao));

			return $var;
		
		}else{

			return $this->comprimeHTML(str_replace('{{visao}}', $bigodim, $visao));
		}
	}

	function push($controlador, $visao, $bigodim = null){
		$this->_eye->setView($controlador, $visao);

		if(is_array($bigodim) and $bigodim !== null and $bigodim !== ''){

			@$var = $this->comprimeHTML(str_replace(array_keys($bigodim), array_values($bigodim), $this->_eye->visao())); 
			return json_encode($var);

		}else{

			return json_encode($this->comprimeHTML(str_replace('{{visao}}', $bigodim, $this->_eye->visao())));
		}
	}

	function Erro404($xhr, $mustache = array()){

		if($xhr === false){

			echo $this->_visao($this->_layout('erro404', 'erro404'), $mustache);

		}else{

			echo $this->push('erro404', 'erro404', $mustache);
		}
	}

	function comprimeHTML($html){

		$html = preg_replace(array("/\/\*(.*?)\*\//", "/<!--(.*?)-->/", "/\t+/"), ' ', $html);

		$mustache = array(
			"\t"		=> ' ',
			" "			=> ' ',
			PHP_EOL		=> ' ',
			'> <'		=> '><',
			'  '		=> ' ',
			'   '		=> ' ',
			'    '		=> ' ',
			'     '		=> ' ',
			'> <'		=> '><',
			'NAOENTER' 	=> PHP_EOL
		);
		
		return str_replace(array_keys($mustache), array_values($mustache), $html);
	}

}