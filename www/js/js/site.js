window.older = false;
window.n = 0;
window.scl = 0;

function getXHRPopStateShowStatus(){
	return XHRPopStateShowStatus;
}

function setXHRPopStateShowStatus(st){
	XHRPopStateShowStatus = st;
}

/* PUSH HISTORY AJAX */
var xhrfn = function(controler, doneCallFn){

	var expPopstate = /!popstate+$/g;
	var expHash = /#[.*\S]+$/g;
	var expHashExtract = /#([.*\S]+)$/i;
	var atualLocation = XHRPopLastController.replace(expHash, '');

	controler = controler.replace(expPopstate, '');
	var testHash = controler;

	controler = controler.replace(expHash, '');

	if(atualLocation != controler){

		if(XHRPopState){
			if(typeof(XHRPopState.abort) === 'function'){
				if(getXHRPopStateShowStatus() === false){
					console.warn('Cancelando request anterior.');
				}
				setXHRPopStateShowStatus(false);
				XHRPopState.abort();
			}
		}

		setXHRPopStateShowStatus(false);

		XHRPopState = DW.ajax({
			'url': controler,
			'data': {push: 'push'},
			'dataType': 'json',
			'done': function(rtn){

				XHRPopLastController = controler;

				setXHRPopStateShowStatus(true);

				doneCallFn();

				if(rtn.title){
					document.title = rtn.title;
				}

				var render = DW.getById('push-conteudo');
				render.innerHTML = '';
				render.innerHTML = rtn;

				DW.delay(function(){

					// SCROLL TO HASH ELEMENT
					if(expHashExtract.test(testHash) === true){
						var idByHash = testHash.match(expHashExtract)[1];
						if(DW.getById(idByHash)){
							var idByHashTop = DW.positionAtTop(DW.getById(idByHash));
							window.scrollTo(0, idByHashTop);
						}else{
							window.scrollTo(0, XHRPopStateScroll[testHash]);
						}
					}else{

						if(XHRPopStateScroll[controler]){
							window.scrollTo(0, XHRPopStateScroll[controler]);
						}else{
							window.scrollTo(0, 0);
						}
					}

				}, 30);

				/* index */
				if(controler === '/' || controler === jsdominio || controler === jsdominio+'/'){

				/* outros */
				}else{
				}
			},
			'error': function(evts){
				if(getXHRPopStateShowStatus() === true){
				/*	DW.warning({'message': 'Não foi possível acessar o conteúdo requisitado, há algum problema com a Internet!'});
*/
				}
			}
		});
	}
};

var lockChangePageFn = function(url){
		if(lockChangePage === true){
			DW.confirm({
				message: lockExitMessage,
				'ok': 'Não sair',
				'no': 'Sair',
				'okFunction': function(){
				},
				'noFunction': function(){
					lockChangePage = false;
					lockClosePage = false;
					DW.pushstate.goXHR(url, xhrfn, '');
				}
			});
		}
	};

if(navigator.userAgent.match(/MSIE 9\.0/)){
	older = true;
}

if(older === false){
	DW.pushstate.init({
		'lockExitMessage': lockExitMessage,
		'xhrfn': xhrfn,
		'lockChangePageFn': lockChangePageFn
	});
}