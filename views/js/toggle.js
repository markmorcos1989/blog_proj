$('#toggle_message').click(function(){
	var value = $('#toggle_message').attr('value'); 
	
	if(value == 'hide')
	{
		$('#toggle_message').attr('value','show');
	}
	else if(value == 'show')
	{
		$('#toggle_message').attr('value','hide');
	}
	
	$('#message').toggle('fast'); 
});

$('#paragraph').click(function(){
	$('#paragraph').hide();
});

