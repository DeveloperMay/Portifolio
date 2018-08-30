function openURL(href){

        var link = href;                     
        $.ajax({                                                             
            url: link,
            type: 'POST',
            data: {push: 'push'},
            cache: false,
            success: function (result) {
                $('#push-conteudo').html(result);
              /*  $.validator.unobtrusive.parse($("form#ValidateForm"));*/
            }
        });
        window.history.pushState({href: href}, '', href);
}

$(document).ready(function() {

   $(document).on('click', 'a', function () {
     openURL($(this).attr("href"));
     return false;
   });  

   window.addEventListener('popstate', function(e){
      if(e.state)
        openURL(e.state.href);
   }); 

});
window.DW = {
	/* ADD EVENTS */
	evts: {
		add: function (evt, el, fn) {
			if(el !== null){
				if(window.addEventListener){
					el.addEventListener(evt, function(evt){
						fn(evt);
					}, true);
				}else{
					el.attachEvent("on"+evt, function(){
						fn(evt);
					});
				}
			}
		}
	},
	trigger: function (ev, el){
		if(document.createEvent){
			evento = document.createEvent('HTMLEvents');
			evento.initEvent(ev, true, true);
			el.dispatchEvent(evento);
		}else{
			evento = document.createEventObject();
			el.fireEvent('on'+ev, evento);
		}
	},
	getById: function(element){
		return document.getElementById(element);
	},
	targt: function (e) {
		e = e.target ? e : window.event;
		return e.target || e.srcElement;
	},
	debounce: function(func, wait, immediate){

		let timeout;
		return function(...args){
			const context = this;
			const later = function(){
				timeout = null;
				if(!immediate) func.apply(context, args);
			};

			const callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if(callNow){
				func.apply(context, args);
			}
		};
	},
	delay: function (fn, tm) {
		window.setTimeout(function () {
			fn();
		}, tm);
	},
	delayPersistent2: (function(fn, ms, label){
		if(typeof(delayPersistent2) === 'undefined'){
			window.delayPersistent2 = {};
		}
		return function(fn, ms, label){
			clearTimeout(delayPersistent2[label]);
			delayPersistent2[label] = setTimeout(fn, ms);
		};
	}())
};	