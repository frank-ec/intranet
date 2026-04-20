//Almacenar slider en una variable
var slider = $('#slider');
var siguinete = $('#btn-next');
var anterior = $('#btn-prev');

//Mover ultima imagen al inicio

$('#slider section:last').insertBefore('#slider section:first');
slider.css('margin-left', '-'+100+'%');

function moverD()
{
	slider.animate({
		marginLeft: '-'+200+'%'}
		,700, function(){
		$('#slider section:first').insertAfter('#slider section:last');
		slider.css('margin-left', '-'+100,'%');


	});

}

function moverI()
{
	slider.animate({
		marginLeft:0}
		,700, function(){
		$('#slider section:first').insertAfter('#slider section:last');
		slider.css('margin-left', '-'+100,'%');


	});

}

siguiente.on('click',function(){
	moverD();


anterior.on('click',function(){
	moverI();
});