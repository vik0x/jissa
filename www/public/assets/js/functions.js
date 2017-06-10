;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {



		// date picker
		if (typeof activeDays != "undefined" ) {

			$( '[data-date]' ).datepicker({
	      		dateFormat: 'mm/dd/yyyy',
	      		beforeShowDay: activeDays,
	      		todayHighlight: true,
	      		keyboardNavigation: false,
			    forceParse: false,
			    language: "es",
			    beforeShowDay: function (date){
			    	for (var i = 0; i < dates.length; i++) {
			    	    if (new Date(dates[i]).toString() == date.toString()) {
			    	        return {
			    	            classes: 'black'
			    	        };
			    	    }
			    	}
			    	return [false,''];
                  // if (date.getMonth() == (new Date()).getMonth())
                  //   switch (date.getDate()){
                  //     case 4:
                  //       return {
                  //         tooltip: 'Example tooltip',
                  //         classes: 'black'
                  //       };
                  //     case 8:
                  //       return false;
                  //     case 12:
                  //       return "black";
                  // }
                }




	      	}).datepicker("setDate", null).on('changeDate',function(e){
	      		date = new Date( e.date );
	      		var datemount = parseInt(date.getMonth()+1) < 10 ? "0" + (date.getMonth()+1) : (date.getMonth()+1);
	      		var dateday = parseInt(date.getDate()) < 10 ? "0" + (date.getDate()) : (date.getDate());
	      		date = date.getFullYear() + '-' + datemount + '-' + dateday;
	      		// console.log(date);
	      		$('[data-fecha]').show();
	      		if( $('[data-fecha="' + date + '"]').length > 0 ){
		      		$('[data-fecha]').addClass('hide_program');
	      			$('[data-fecha="' + date + '"]').removeClass('hide_program');

	      		}
	      		else{
	      			$('[data-fecha]').hide();
	      			$('.alert').fadeIn(200);
	      			setTimeout(function(){
	      				$('.alert').fadeOut(300);
	      			},1200);
	      		}
	      		$('.hide_program').hide();
	      		$('[data-fecha]').removeClass('hide_program');

	      	});



		}



		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});


		$win.on('scroll', function() {
			var winT = $win.scrollTop();

			if ( winT > + 20 ) {
				$('.header').addClass('fixed')
			} else {
				$('.header').removeClass('fixed')
			};
		});



		//close lightbox
		$('.close').click(function(e){
			e.preventDefault();
			$('.lightbox--module').fadeOut();
		});

		function validEmail( $email ) {

		  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		  return emailReg.test( $email );

		}

		$('.date input').datepicker({
			language: "es",
		    autoclose: true,
		    todayHighlight: true,
		    toggleActive: true,
		    maxViewMode: 1,
		});

		//-----> Procesamos formulario de news
		$("input.subscribe-btn").click( function( e ){

		    e.preventDefault();

		    var $data = $("#mail").val();
		    var $token = $("input[name=_token]").val()

		    $("#subscribe-message").remove();

		    console.log( "Email: " + $data );

		    if( ! validEmail( $data ) || $data.length == 0 ){

		        $("#mail").css("border-color", "#ed1c1c");
		        return false;

		    }else{

		    	$("#mail").css("border-color", "#a5a5a5");

		    	$.ajax({ type: "POST",
                    url: '/contacto/newsletter',
                    data: {send_data: "sent", email: $data, _token: $token },
                    error: function(){

                    },
                    success: function(response){

                    			console.log( response );

                    			var $resp = $.parseJSON( response );

                    			if( $resp.status ){

                    				$("#mail").val("");
                    				$(".subscribe-inner").append( '<div id="subscribe-message" style="padding: 15px;color: green;font-weight: bold;">' + $resp.message + '</div>' )

                    			}else{

                    				$(".subscribe-inner").append( '<div id="subscribe-message" style="padding: 15px;color: red;font-weight: bold;">' + $resp.message + '</div>' )

                    			}

                            },
                });

		    }



		} );

		//burger btn
		$('.nav-trigger').on('click', function (event) {
			event.preventDefault();
			$(this).toggleClass('active');
			$('.nav').stop(true,true).slideToggle();
			$('.header').toggleClass('nav-mobile-open');
			$('html, body').toggleClass('mobile-fixed');
		});

		$('.btn-search').on('click', function (event) {
			$(this).toggleClass('active');
			event.preventDefault();
			$('.search .search-actions').slideToggle();
		});


			if ($win.width() <= 1025) {
				$('.nav .has-dropdown > a').on('click', function (event) {
					event.preventDefault();
					$(this).parent().toggleClass('active');
				});
			}


		//Custom Dropdowns
		$('.select').dropdown();

		//slider intro
		$('.slider-intro .slides').slick({
			dots: false,
			arrows: true,
			prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
			slidesToShow: 1,
			slidesToScroll: 1,
			swipeToSlide: true,
			infinite: false,
			touchMove: false,
			swipeToSlide: false,
			autoplay: true,
			infinite: true,
  			autoplaySpeed: 3000
		});

		$('.slider-intro .slick-dots').wrap('<div class="slick-dots-wrapper"><div class="shell"></div></div>')

		//slider games
		$('.slider-games .slides').slick({
			dots: false,
			arrows: true,
			slidesToShow: 4,
			slidesToScroll: 1,
			swipeToSlide: true,
			responsive: [
				{
					breakpoint: 1150,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
				  	}
				}
			]
		});

		//slider games
		$('.slider-games-available .slides').slick({
			dots: false,
			arrows: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			swipeToSlide: true,
		});

		$('.slider-gallery .slides').slick({
			dots: false,
			arrows: true,
			centerMode:true,
			centerPadding: '0',
			slidesToShow: 3,
			slidesToScroll: 1,
			swipeToSlide: true,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 3,
						slidesToScroll: 1
					}
				},
				{
					breakpoint: 767,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
				  	}
				}
			]
		});

		$('.slider-secondary .slides').slick({
			dots: false,
			arrows: true,
			prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
			centerMode:true,
			centerPadding: '0',
			slidesToShow: 1,
			slidesToScroll: 1,
			//autoplay: true,
  			//autoplaySpeed: 2000,
			swipeToSlide: true
		});

		$('.slider-secondary .slick-dots').wrap('<div class="slick-dots-wrapper"><div class="shell"></div></div>');

		$('.slider-providers .slides').slick({
			dots: false,
			arrows: true,
			infinite: false,
			touchMove: false,
			swipeToSlide: false,
			initialSlide: 1,
			swipe : true,
			centerMode: true,
			centerPadding: '0',
			slidesToShow: 3,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 2000,
			swipeToSlide: true
		});


		//carousel sport calendar
   		$('.sport-calendar').slick({
			  infinite: false,
			  slidesToShow: 6,
			  slidesToScroll: 1,
			  responsive: [
			    {
			      breakpoint: 1023,
			      settings: {
			        slidesToShow: 4
			      }
			    },
			    {
			      breakpoint: 767,
			      settings: {
			        slidesToShow: 3
			      }
			  	},
			      {
			      breakpoint: 540,
			      settings: {
			        slidesToShow: 2
			      }
			    }
			  ]
			});

		// slider promociones apuesta
   		$('.slider-bet').slick({
		  dots: true,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 1,
		  adaptiveHeight: true
		});

		// $('.slider-gallery .slide').each(function() {
		// 	var imageSrc = $(this).find('img').attr('src');
		// 	$(this).find('.slide-image').css('background-image','url(' + imageSrc + ')')
		// });


		//scroll to next section
		$('.btn-scroll').click(function (e) {
			e.preventDefault();

			var anchor = $('.anchor')

			$('body, html').animate({
				scrollTop: $(anchor).height()
			}, 900);
		});

		//scroll to next section
		$('.btn-top').click(function (e) {
			e.preventDefault();
			 $('body, html').animate({
				scrollTop: $('body, html').offset().top
			}, 900);
		});

		//subscribe
		$('.btn-form').on('click',function(e) {
			e.preventDefault();

			$(this).siblings('.subscribe-body-hidden').addClass('shown')
			$(this).addClass('hidden');
		})

		// promo slider
		$('.promo-slider').slick({
		  infinite: true,
		  slidesToShow: 2,
		  slidesToScroll: 1,
		  responsive: [

		    {
		      breakpoint: 992,
		      settings: {
		        slidesToShow: 1,
		      }
		    }
		  ]
		});



		//footer-socials fix dropdown on mobile (add class)
		$('.socials-footer  > ul > li > a').on('click', function (event) {
			event.preventDefault();
			$(this).parent('li').toggleClass('active');
		});

	// Image
		    $('.image-back').replaceWith(function(i, v){
		        return $('<figure/>', {
		            style: 'background-image: url('+this.src+')',
		        })
		    });

		    // scrollChange
		function scrollChange() {
			var elScroll,
				iconScroll;

			function getScroll() {
				elScroll = $( '.shell-btn' ).offset().top;
				iconScroll = $( '.icon-wrapper' ).offset().top;
				console.log( elScroll, iconScroll );

				if ( elScroll >= ( iconScroll - 50 ) ) {
					$( '.list-buttons' ).addClass( 'list-buttons--change' );
				} else {
					$( '.list-buttons' ).removeClass( 'list-buttons--change' );
				}

				if( elScroll >= iconScroll ) {
					$( '.list-buttons' ).css({
						opacity: 0,
						display: 'none'
					});
				} else {
					$( '.list-buttons' ).css({
						opacity: 1,
						display: 'block'
					});
				}
			}

			if($('.shell-btn').length){
				$( window ).on( 'scroll', getScroll );
			}
		}

		scrollChange();


	}); //jQuery end



	$(function() {
		var map;
		function initialize() {

			// Create an array of styles.
			var styles = [
				{
					"featureType": "all",
					"elementType": "labels.text.fill",
					"stylers": [
						{
							"saturation": 0
						},
						{
							"color": "#000000"
						},
						{
							"lightness": 40
						}
					]
				},
				{
					"featureType": "all",
					"elementType": "labels.text.stroke",
					"stylers": [
						{
							"visibility": "off"
						},
						{
							"color": "#000000"
						},
						{
							"lightness": 0
						}
					]
				},
				{
					"featureType": "all",
					"elementType": "labels.icon",
					"stylers": [
						{
							"visibility": "off"
						}
					]
				},
				{
					"featureType": "administrative",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#000000"
						},
						{
							"lightness": 20
						}
					]
				},
				{
					"featureType": "administrative",
					"elementType": "geometry.stroke",
					"stylers": [
						{
							"color": "#000000"
						},
						{
							"lightness": 17
						},
						{
							"weight": 0
						}
					]
				},
				{
					"featureType": "landscape",
					"elementType": "geometry",
					"stylers": [
						{
							"color": "#d6d6d6"
						},
						{
							"lightness": 20
						}
					]
				},
				{
					"featureType": "poi",
					"elementType": "geometry",
					"stylers": [
						{
							"color": "#bcbcbc"
						},
						{
							"lightness": 21
						}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#aaaaaa"
						},
						{
							"lightness": 0
						}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry.stroke",
					"stylers": [
						{
							"color": "#ebebeb"
						},
						{
							"lightness": 29
						},
						{
							"weight": 0
						}
					]
				},
				{
					"featureType": "road.arterial",
					"elementType": "geometry",
					"stylers": [
						{
							"color": "#ebebeb"
						},
						{
							"lightness": 0
						}
					]
				},
				{
					"featureType": "road.local",
					"elementType": "geometry",
					"stylers": [
						{
							"color": "#ebebeb"
						},
						{
							"lightness": 0
						}
					]
				},
				{
					"featureType": "transit",
					"elementType": "geometry",
					"stylers": [
						{
							"color": "#bcbcbc"
						},
						{
							"lightness": 0
						}
					]
				},
				{
					"featureType": "water",
					"elementType": "geometry",
					"stylers": [
						{
							"color": "#dfdfdf"
						},
						{
							"lightness": 17
						}
					]
				}
			];

			var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

			var isDraggable = $(document).width() > 480 ? true : false;

			var map_element = $('#googlemap');
			var bounds = new google.maps.LatLngBounds();
			var myLatLng = new google.maps.LatLng(map_element.data('lat'),map_element.data('lng'));
			var mapOptions = {
				zoom: 17,
				center: myLatLng,
				disableDefaultUI: true,
				mapTypeControl: false,
				draggable: isDraggable,
				scrollwheel: true,
				zoomControl: false,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.SMALL
				},
				panControl:true
			};

			bounds.extend(myLatLng);

			map = new google.maps.Map(document.getElementById('googlemap'),mapOptions);

			var image = 'css/images/marker.png';
			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: image
			});

			google.maps.event.addDomListener(window, "resize", function() {
				google.maps.event.trigger(map, "resize");
				map.setCenter( bounds.getCenter() );
			});

			map.mapTypes.set('map_style', styledMap);
			map.setMapTypeId('map_style');
		}

		if ($('.section-map').length > 0) {
			google.maps.event.addDomListener(window, 'load', initialize);
		}
	});
})(jQuery, window, document);

$(function() {
  // Generic selector to be used anywhere
  $(".stick-nav ul li a, .btn-scroll").click(function(e) {

    // Get the href dynamically
    var destination = $(this).attr('href');

    // Prevent href=“#” link from changing the URL hash (optional)
    e.preventDefault();

    // Animate scroll to destination
    $('html, body').animate({
      scrollTop: $(destination).offset().top
    }, 500);
  });

	$('body').on( 'click touchstart', '.fs-dropdown-selected', function(){
		$(this).parent().addClass('fs-dropdown-open');
	});

	/*$('body').on( 'click touchstart', '.fs-dropdown-item', function(){
		$(this).parents('.fs-dropdown').removeClass('fs-dropdown-open');
	});*/

});


//Check to see if the window is top if not then display button
$(window).scroll(function(){
	if ($(this).scrollTop() > 1000) {
		$('.button-section').fadeOut();
	} else {
		$('.button-section').fadeIn();
	}
});





!function(a){a.fn.datepicker.dates.es={days:["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"],daysShort:["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"],daysMin:["Do","Lu","Ma","Mi","Ju","Vi","Sa"],months:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],monthsShort:["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],today:"Hoy",monthsTitle:"Meses",clear:"Borrar",weekStart:1,format:"dd/mm/yyyy"}}(jQuery);
