$(function(){

	$('#filter').on('change', function () {
    	var url = window.location.origin + window.location.pathname;
    	url += '?f=' + $(this).val();
      window.location = url;
      return false;
  	});

});