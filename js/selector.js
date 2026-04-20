$(document).ready(function()
{

	$('#seliden').on('change',function()
	{
		var selectValor = '#'+$(this).val();

		$('#cedu').children('div').hide();
		$('#cedu').children(selectValor).show();

	});



});