$.fn.open = function(options){
	defaults = {
        image : false,
        type : 'submit',
        color : '#FFFFFF',
    }
	var objLoader = $(this);
	var image = options.image;
	var intoDiv = $('<div class="centrarLoader"></div>');
	var beforediv = $('<div></div>');
	intoDiv.css('background-color', options.color);
	var imagenLoaderDiv = $('<img src="'+ image +'" class="img-responsive center">');
	intoDiv.append(imagenLoaderDiv);
	beforediv.append(intoDiv);
	beforediv.addClass('externDivLoader');
	objLoader.append(beforediv);
}

$.fn.close = function(){
	var objLoader1 = $(this);
	objLoader1.delay('50').fadeOut('slow', function(){
		objLoader1.removeAttr('style');
		objLoader1[0].innerHTML = "";
	});
}