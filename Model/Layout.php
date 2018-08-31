<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "14/08/2018",
	"MODEL": "Layout",
	"LAST EDIT": "18/08/2018",
	"VERSION":"0.0.2"
}
*/


/**
**
** @see o Layout precisa ser formato .HTML ou confirgurar no arquivo Setting.php 
**
**/

class Model_Layout extends Model_View{

	public function setLayout($st_view){

		try{

			if(file_exists(DIR.'Layout/'.$st_view.EXTENSAO_VISAO)){

				$this->st_view = $st_view;
			}


		}catch(PDOException $e){

			/**
			** ERRO, LAYOUT NÃO ENCONTRADO
			**/
			new de('layout não encontrado');
		}
	}

	public function Layout(){

		try{

			$layout = LAYOUT;

			/* COLOCAR CACHE NOS ARQUIVOS STATICOS QUANDO NÃO ESTÁ EM PRODUÇÃO */
			$cache = '';
			$random = mt_rand(10000, 99999);

			if(DEV !== true){
				$cache = '?cache='.$random;
			}

			$mustache = array(
				'{{static}}' 		=> URL_STATIC,
				'{{header}}' 		=> $this->_headerHTML(),
				'{{cache}}' 		=> $cache,
				'{{lang}}'			=> $this->_url
			);

			$layout = str_replace(array_keys($mustache), array_values($mustache), file_get_contents(DIR.'Layout/'.$layout.EXTENSAO_VISAO));
			return $layout;

		}catch(PDOException $e){

			new de('nada de layout');
			/**
			** ERRO, ARQUIVO LAYOUT NÃO ENCONTRADO
			**/
		} 
	}

	private function _headerHTML(){

		$url = $this->url;
		
		$noscript = '<noscript><meta  http-equiv="refresh"  content="1; URL=/noscript"  /></noscript>';
		if(isset($url[1]) and $url[1] == 'noscript'){

			$noscript = '';
		}

		$header = <<<php
<title>DevWeb</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes, initial-scale=1" />
<meta name="msapplication-tap-highlight" content="no" />
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta  name="robots" content="index, no-follow" />
{$noscript}
<meta name="msapplication-tap-highlight" content="no"/>
<meta name="apple-mobile-web-app-title" content="Maydana System"/>
<meta name="application-name" content="Maydana System"/>
<meta name="msapplication-TileImage" content="/img/caveira.png"/>
<meta name="msapplication-TileColor" content="#e8e6e8"/>
<meta name="theme-color" content="#1c5f8e"/>
<meta name="author" content="Matheus Maydana" />
<link rel="manifest" href="/manifest.json"/>
<link rel="shortcut icon" href="/img/site/caveira.png" type="image/x-icon">
<link rel="icon" href="/img/site/caveira.png" type="image/x-icon">
<script src="/js/MS.min.js{{cache}}"></script>
<script>
	window.lastWidth = 0;
	var imoveislist = {};
	var lockClosePage = true;

	/* lockChangePage é padrão false, quando alterar algum formulário troque o valor da variavel a true então vai bloquear a troca de tela*/
	var lockChangePage = false;
	var jsdominio = 'portifolio.local';
	var lockExitMessage = 'Algumas informações ainda não foram salvas. Deseja sair sem salvar estas alterações?';
	var XHRPopState;
	var XHRPopLastController = '/';
	var XHRPopStateScroll = {};
	var XHRPopStateShowStatus = true;
</script>
<script src="/js/site.min.js{{cache}}"></script>
		
php;

		return $header;
	}


	protected function _navi(){

		return '';
	}
}