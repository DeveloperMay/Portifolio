<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "14/08/2018",
	"MODEL": "View",
	"LAST EDIT": "18/08/2018",
	"VERSION":"0.0.2"
}
*/

/**
**
** @see a View precisa ser formato .HTML ou confirgurar no arquivo Setting.php 
**
**/

class Model_View extends Model_Functions_Functions{

	public function setView($controlador, $st_view){

		try{

			if(file_exists(DIR.'View'.$this->lang.'/'.$controlador.'/'.$st_view.EXTENSAO_VISAO)){

				$this->st_view = $st_view;
				$this->st_controlador = $controlador;

			}else{
				
				new de('visao não encontrado');
			}

		}catch(PDOException $e){

			/**
			** ERRO, VISÃO NÃO ENCONTRADA
			**/
		}
	}

	function visao(){

		try{

			if(isset($this->st_view)) {

				$visao = $this->st_view;
				$controlador = $this->st_controlador;

				if(file_exists(DIR.'View'.$this->lang.'/'.$controlador.'/'.$visao.EXTENSAO_VISAO)){

				$mustache = array();

				$visao = str_replace(array_keys($mustache), array_values($mustache), file_get_contents(DIR.'View'.$this->lang.'/'.$controlador.'/'.$visao.EXTENSAO_VISAO));

					return $visao;

				}else{
					/**
					** Erro na visão
					**/
					new de('visao não encontrado');
					//echo 'erro no diretorio da visão';
				}
			}

		}catch(PDOException $e){

			new de('visao não encontrado');
			/**
			** ERRO, ARQUIVO VISÃO NÃO ENCONTRADO
			**/
		}
	}
}