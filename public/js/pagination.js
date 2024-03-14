$(function(){

	var getUrlParameter = function getUrlParameter(sParam) {
	    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	        sURLVariables = sPageURL.split('&'),
	        sParameterName,
	        i;

	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');

	        if (sParameterName[0] === sParam) {
	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	};

	$('#pagination').on('change', function () {
    	var url = window.location.origin + window.location.pathname;
    	url += '?n=' + $(this).val();
    	url += getUrlParameter('q') == undefined ? '' : '&q=' + getUrlParameter('q');
       	window.location = url;
      	return false;
  	});

  	var search = function search(){
  		var url = window.location.origin + window.location.pathname;
  		url += '?q=' + $('#search_text').val();
  		url += getUrlParameter('n') == undefined ? '' : '&n=' + getUrlParameter('n');
  		window.location = url;
      	return false;
  	};

  	$('#search_button').click(function(){
  		search();
  	});

  	$(document).keypress(function(e) {
	    if(e.which == 13) {
	    	e.preventDefault();
	        search();
	    }
	});

	$('#search_clear').click(function(){
  		var url = window.location.origin + window.location.pathname;
    	url += getUrlParameter('n') == undefined ? '' : '?n=' + getUrlParameter('n');
       	window.location = url;
      	return false;
  	});
});