//var count = $('*').length;
//alert("there are "+count+" elements in this page");

//var count = $('#contents').find('*').length;
//alert("there are "+count+" elements in this part");

//var count = $('#contents').find('label').length;
//alert("there are "+count+" labels in this part");

//var name = $('#password').val();
//alert(name);

//var text = $('#text').text();
//alert(text);

//$('p:first').text('hello');

//$(':submit').click(function(){
	//alert("u clicked submit");
//});

//$(':submit').click(function(){
	//$(this).attr('value','please wait...'); //when you click this submit button the value will change to please wait...
//});


$(':text').focusin(function() {
	$(this).css('background-color', 'yellow');
});

$(':text').focusout(function() {
	$(this).css('background-color', 'fff');
});

$(':button').click(function() {
	$('p').css('background-color', 'yellow').css('color', 'white');
});

$('#button, #paragraph').click(function() {
	alert('something was pressed');
});

$(document).ready(function() {
	$('.table tr:even').addclass('highlight');
});

$(document).ready(function() {
	$('.table tr:odd').addclass('highlight');
});

$(document).ready(function() {
	var email_default = "enter your email address...";
	
	$('input[type="email"]').attr('value', email_default).focus(function()
	{
		if($(this).val()== email_default)
		{
			$(this).attr('value', '');
		}
	}).blur(function(){
		if($(this).val()=='')
		{
			$(this).attr('value', email_default);
		}
	});
});

$(document).ready(function() {
	$('#search_name').keyup(function()
	{
		search_name = $(this).val();
		
		$('#names li').removeClass('highlight');
		
		if(jQuery.trim(search_name) != '')
		{
			$("#names p:contains('" + search_name + "')").css('background-color', 'yellow');
		}
	});
});





