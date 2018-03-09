/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Projects & Project Images Sorting Scripts
 * Created by CMSMasters
 * 
 */


jQuery(document).ready(function ($) { 
	var projectsList = jQuery('#projects-list');
	
	projectsList.sortable( { 
		update : function (event, ui) { 
			jQuery('#loading-animation').show();
			
			opts = { 
				url : ajaxurl, 
				type : 'POST', 
				async : true, 
				cache : false, 
				dataType : 'json', 
				data : { 
					action : 'projects_sort', 
					order : projectsList.sortable('toArray').toString() 
				},
				success : function (response) { 
					jQuery('#loading-animation').hide();
					
					return;
				},
				error : function(xhr, textStatus, e) { 
					alert('There was an error saving the updates');
					
					jQuery('#loading-animation').hide();
					
					return;
				} 
			};
			
			jQuery.ajax(opts);
		} 
	} );
} );

jQuery(document).ready(function ($) {
	var slidesList = jQuery('#folio_imgs');
	
	slidesList.sortable( { 
		placeholder : 'ui-sortable-placeholder', 
		update : function (event, ui) { 
			jQuery('#loading-animation').show();
			
			opts = { 
				url : ajaxurl, 
				type : 'POST', 
				async : true, 
				cache : false, 
				dataType : 'json', 
				data : { 
					action : 'imgs_sort', 
					order : slidesList.sortable('toArray').toString() 
				},
				success : function (response) { 
					jQuery('#loading-animation').hide();
					
					return;
				},
				error : function (xhr, textStatus, e) { 
					alert('There was an error saving the updates');
					
					jQuery('#loading-animation').hide();
					
					return;
				} 
			};
			
			jQuery.ajax(opts);
		} 
	} );
} );
