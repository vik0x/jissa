$(document).ready(function(){
	$('.fs-dropdown').on('change', function(){
		$('.section-listings').show();
		if( $('[data-sucursal="' + $('.fs-dropdown-item_selected').attr('data-value') + '"]').length > 0 ){
			$('.section-listings').addClass('not-show');
			$('[data-sucursal="' + $('.fs-dropdown-item_selected').attr('data-value') + '"]').removeClass('not-show');
			$('.not-show').hide();
			$('.section-listings').removeClass('not-show');
		}
	});
	// });
	// .on('changeDate',function(e){
 //  		date = new Date( e.date );
 //  		date = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
 //  		$('[data-fecha]').show();
 //  		if( $('[data-fecha="' + date + '"]').length > 0 ){
 //      		$('[data-fecha]').addClass('hide_program');
 //  			$('[data-fecha="' + date + '"]').removeClass('hide_program');
 //  		}
 //  		else{
 //  			$('.alert').fadeIn(200);
 //  			setTimeout(function(){
 //  				$('.alert').fadeOut(200);
 //  			},5000);
 //  		}
 //  		$('.hide_program').hide();
 //  		$('[data-fecha]').removeClass('hide_program');
 //  	});
});