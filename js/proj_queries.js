//user_count.php
$('#toggle_users').click(function(){ //#toggle_users is the id of the button 
	var value = $('#toggle_users').attr('value');
	
	//var value = $('#toggle_users').val(); is also right
	
	if(value == 'hide number of users')
	{
		$('#toggle_users').attr('value','show number of users');
	}
	else if(value == 'show number of users')
	{
		$('#toggle_users').attr('value','hide number of users');
	}
	
	$('#user_count').toggle('fast'); //#user_count is the id of the part we want to show and hide
});
//we can use dblclick for double click 

//view_comments.php(class) 
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

//show_post.php(class) //index.php(class)
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

//change color of text, textarea, password fields to yellow when you click on them and to white when you click out of them
$(':text, #textarea, :password').focusin(function() {
	$(this).css('background-color', 'yellow');
});

$(':text, #textarea, :password').focusout(function() {
	$(this).css('background-color', 'white');
});

//changing font size //menu.php
function change_size(elementss, size)
{
	var current = parseInt(elementss.css('font-size'));
	if (size == 'smaller')
	{
		var new_size = current - 2;
	}
	else if(size == 'bigger')
	{
		var new_size = current + 2;
	}
	elementss.css('font-size', new_size + 'px');
}

$('#smaller').click(function(){
	change_size($('*'), 'smaller'); //'*' means all elements
});

$('#bigger').click(function(){
	change_size($('*'), 'bigger');
});

//enable submit button after chosing a file //upload_pic_form.html
$(document).ready(function(){
	$('#submit').attr('disabled', true); //default 
	$('#file').change(function(){
		if($("#file")[0].files.length == 0 ){ //check if no file is picked
			$('#submit').attr('disabled', true);
		}
		else
		{
			$('#submit').attr('disabled', false);
		}
	});
});

//search, find and highlight
function highlightText(text, node) {
    var searchText = $.trim(text).toLowerCase(),
        currentNode = node,
        matchIndex, newTextNode, newSpanNode;
    while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) {
        newTextNode = currentNode.splitText(matchIndex);
        currentNode = newTextNode.splitText(searchText.length);
        newSpanNode = document.createElement("span");
        newSpanNode.className = "highlight";
        currentNode.parentNode.insertBefore(newSpanNode, currentNode);
        newSpanNode.appendChild(newTextNode);
    }
}

$(document).ready(function(){
	$("#search_b").click(function(){
		var text = $("#searchtext").val();
		$("*").contents().filter(function () {
			return this.nodeType === this.TEXT_NODE;
		}).each(function () {
			highlightText(text, this);
		});
	});
});

//hover link discription
$("#addpos").hover(function(){
	$("#link_feedback").html("");
});

//bind
$(document).ready(function(){
	$('a').bind('mouseenter mouseleave', function(){
		$(this).toggleClass('bold'); 
	});
});



//text remaining
$(document).ready(function(){
	var text_max = 55;
	$('#textarea_feedback').html(text_max +' characters remaining');
	
	$('#textarea').keyup(function(){
		var text_length = $('#textarea').val().length;
		var text_remaining = text_max - text_length;
		
		$('#textarea_feedback').html(text_remaining +' characters remaining');
	});
});

//hover over description

$('#reg_btn').click(function(){
	if($('#2').val()=="" || $('#1').val()=="" || $('#3').val()=="" )
	{
		//$('.login-form').css('display','none');
		//$('.register-form').css('display','block');
		$('.error').html("fuck this shit");
	}
	else
	{
		$('.error').html("fuck");
	}
});