$(document).ready(function(){

// FUNCIONES



//----- Back image
$('.image').replaceWith(function(i, v){
    return $('<figure/>', {
        style: 'background-image: url('+this.src+')', 
    }) 
});


//----- Stick launchers
$(function(){

        function validEmail( $email ) {

  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );

}

//-----> Procesamos formulario de news
$("input.subscribe-btn").click( function( e ){

    e.preventDefaut();

    var $data = $(".subscribe-inner input[type=email]").val(); 

    console.log( "Email: " + $data );

    if( ! validEmail( $data ) ){

        $(".subscribe-inner input[type=email]").css("border-color", "#ed1c1c");
        return FALSE;

    }



} );

        // Check the initial Poistion of the Sticky Header
        var stickyHeaderTop = $('.mapa').offset().top;
 
        $(window).scroll(function(){
                if( $(window).scrollTop() > stickyHeaderTop ) {
                        $('.launchers').addClass('active');
                } else {
                        $('.launchers').removeClass('active');
                }
        });
  });


//--- tabs
$('.tabs label').click(function(e){
	e.preventDefault();
	$('.tabs label').removeClass('active');
	$('.tab-content').removeClass('active');
	$(this).addClass('active');
	$('#tab-content' + $(this).attr('data-div')).addClass('active');
});


//--- Slick planta A
$('.slick-plta').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  dots:false,
  infinite: false,
  responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 700,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

//--- Slick carousel proto
$('.carousel-proto').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  dots:false,
});

//--- Open light
$('.coords-plta a').click(function(e){
	e.preventDefault();
	$('.lightbox-proto').addClass('active');
	$('.container-light').addClass('active');
	//$('#proto-'+$(this).attr('data-div')).addClass('active');
});
//--- Open light
$('.close-light').click(function(e){
	e.preventDefault();
	$('.lightbox-proto').removeClass('active');
	$('.container-light').removeClass('active');
});


//--- open home
$('#landing .menu-top .btn-ham a').click(function(e){
	e.preventDefault();
});

});




