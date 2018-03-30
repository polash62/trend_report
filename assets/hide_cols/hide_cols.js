/* ----------------------------------------------------------------------
* File name:		jquery.hide_cols.js
* Description:	xxx
* Website:			generic jQuery plugin
* Version:			1.0
* Date:					28-6-2016
* Author:				Ray Hyde - www.rayhyde.nl
---------------------------------------------------------------------- */

(function ($) {
	$.fn.hideCols = function (options) {

		// default settings
		var settings = $.extend({
			hideColumn: '&times;',
			unhideColumn: '<span class="glyphicon glyphicon-eye-open"></span>  Column',
			unhideAll: '<span class="glyphicon glyphicon-eye-open"></span>  All Columns',
			autoSort: true
		}, options);
		
	//translations
	var $table = this,
			$show = $('#show'),
			links = 0;

	// add close buttons to each th, wrapped in a div as absolute positioning does not work
	// in a table cell
	$table + $('th')
			.css({
				paddingRight: 0,
				paddingTop: 0		
			})
			.prepend('<div class="closeWrap"><button class="hide-col">' + settings.hideColumn + '</button>')
			.append('</div>')
		;
		if ( settings.autoSort == false) {
			$show.append('<a href="" class="sort btn btn-sm btn-default">Sort</a>');
		}
		function sortButtons() {
			var listitems = $show.find('button').get();
			listitems.sort(function(a, b) {
				 var compA = $(a).data('show');
				 var compB = $(b).data('show');
				 return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
			})
			$.each(listitems, function(idx, itm) { $show.append(itm); });
		}
	//this happens when a close button is clicked:
	$table + $('th .hide-col').click(function() {
		$show.find('.sort').show();
		//hides the th of the column that is clicked
		var col = $(this).parent().parent('th').index();
		$(this).parent().parent('th').fadeOut('slow');

		//hides the td of the column that is clicked in each row
		$table + $('tr').each(function() { 
			$('td:eq(' + col + ')',this).fadeOut('slow');
		});

		//check if the link to show all columns already exists, if not then add one
		if($show.find('button').length == 0) {
			$show.append('<button data-show="0" class="btn btn-sm btn-warning unhideAll">' + settings.unhideAll + '</button>');
		}

		//adds a link to again show a single hidden column
		$show.append('<button data-show="' + col + '" class="btn btn-sm btn-primary">' + settings.unhideColumn + ' ' + (col + 1)  + '</button>');

		links++;
		if (settings.autoSort == true ) {			
			sortButtons();
		}
		return false;
	});
		
	//this happens when a link to show one or all columns is clicked:
	$show.on('click','button', function(event){

		if ($(this).hasClass('unhideAll')) {
			//when the link to show all columns is clicked
			$show.children('button').remove(); //remove all show columns links
			$show.find('.sort').hide(); //hide sort button
			this + $('td, th').fadeIn('slow'); //show all hidden cells
		} else {
			//gets the number of the columns to be shown
			var col = $(this).data('show');

		//displays the td and th of the column that is clicked in each row
		$table + $('tr').each(function() { 
			$('th:eq(' + col + '),td:eq(' + col + ')',this).fadeIn('slow');
		});

		links--;
		//remove unhideAll when there are no more individual show links
		if (links == 0) {
			$show.children().remove(); //remove all show columns links
		}				
		//remove this show link
		$(this).next('br').remove();
		$(this).remove();
		}
	});	
		
		$show.on('click', '.sort', function() {
			sortButtons();
			return false;
		});
	}
}(jQuery));