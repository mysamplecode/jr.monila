// JavaScript Document
jQuery("#jQueryUISlider").slider();
				jQuery( "#slider-range" ).slider({
					range: true,
					min: 0,
					max: 500,
					values: [ 75, 200 ],
					slide: function( event, ui ) {
						$( "#rangeAmount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
					}
				});
				jQuery( "#rangeAmount" ).val( "PKR" + $( "#slider-range" ).slider( "values", 0 ) +
					" - PKR" + $( "#slider-range" ).slider( "values", 1 ) );
