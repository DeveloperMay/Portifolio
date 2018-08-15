<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "14/08/2018",
	"MODEL": "Exception",
	"LAST EDIT": "14/08/2018",
	"VERSION":"0.0.1"
}
*/
class Model_Functions_Exception extends Exception{

	public $_conexao;
	
	public $_consulta;

	public $_validacao;

	function __construct($conexao){

		$this->_conexao = $conexao;

		$this->_validacao = new Model_Pluggs_Validacao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);
	}

	function nameFunction(array $dados) {

		try {

			return $this->_consulta->saveImagem($dados);

		}catch (Exception $e) {

			return 85;

		}catch(Error $e){

			return 85;
		}
	}
}