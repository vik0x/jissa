/*:::::::::::

    Delay
    
::::::::::*/
var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

/*:::::::::::

    Mediaquerie
    
::::::::::*/

var mediaquerie = function() {
    var pause = 10;
    var widthhh = 0; // FixResize
    $(window).load(function(){
       widthhh = $(window).width();
    });
    
     
    function actions(){
            var width = $(window).width();
            //:::: BeginWidth ::::::
            if(widthhh != $(window).width()) {
                if( width >= 701 ) {
                    //---->Desktop
                    
                    //---- Move
                   $('.share-top').insertAfter('.price-top');
                   $('.black-footer').insertAfter('.blue-footer');
                   $('.st-txt').insertBefore('.photo-pr');
                    
                    
                }  else if( width >= 0 && width <= 700 ) {
                   //----> Mobile
                    
                   //---- Move
                   $('.share-top').insertAfter('.description-desarrollo');
                   $('.black-footer').insertBefore('.blue-footer');
				   $('.move-opciones').insertAfter('.description-proto-top');
				   $('.st-txt').insertAfter('.photo-pr');
                }
            }
		}
		actions();
	 $(window).resize(function(e) {
       delay(function() {
            actions();
        }, pause );
    });

    $(window).resize();
}

/*:::::::::::

    ie Detection
    
::::::::::*/

function isIE( version, comparison ){
    var $div = $('<div style="display:none;"/>').appendTo($('body'));
    $div.html('<!--[if '+(comparison||'')+' IE '+(version||'')+']><a>&nbsp;</a><![endif]-->');
    var ieTest = $div.find('a').length;
    $div.remove();
    return ieTest;
}

$(document).ready(function() {
	if(isIE(8))	{
    
    } 
	else {
        //---------> Mediaquerie
		mediaquerie();
    }
});	