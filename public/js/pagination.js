$(function(){
	$('#pagination').on('change', function () {
    	var url = window.location.origin + window.location.pathname + '?n=';
    	url += $(this).val();
       	window.location = url;
      	return false;
  	});
});