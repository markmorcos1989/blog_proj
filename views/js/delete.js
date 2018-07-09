$('#delete_comment').click(function(){
	var c = confirm('are you sure you want to delete this comment ?');
	if(c)
	{
		return true;
	}
	else
	{
		return false;
	}
});

$('#delete_post').click(function(){
	var c = confirm('are you sure you want to delete this post ?');
	if(c)
	{
		return true;
	}
	else
	{
		return false;
	}
});

