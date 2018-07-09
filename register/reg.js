//AJAX //JQ
$(document).ready(function(){
	$('#register').click(function(e){
		e.preventDefault();
		var username = $("#username").val();
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		var password = $("#password").val();
		var password_again = $("#password_again").val();
		var email = $("#email").val();
		
		$('#username_error').html("");
		$('#firstname_error').html("");
		$('#lastname_error').html("");
		$('#password_error').html("");
		$('#password_again_error').html("");
		$('#email_error').html("");
		$('#activate').html("");
		
		$.ajax({
			url:"register.php",
			method:"POST",
			data:{
				username:username,
				firstname:firstname,
				lastname:lastname,
				password:password,
				password_again:password_again,
				email:email
			},
			dataType:"JSON",
			success:function(data){
				$('#username_error').html(data.username);
				$('#firstname_error').html(data.firstname);
				$('#lastname_error').html(data.lastname);
				$('#password_error').html(data.password);
				$('#password_again_error').html(data.password_again);
				$('#email_error').html(data.email);
				$('#activate').html(data.activate);
			}
		})
	});
});


//JS
//Username
function username_keyup(){
	var username = reg.username.value;
	var re = /^[\w ]+$/; 

	document.getElementById("username_error").innerHTML="";
	
	if(username=="")
	{
		document.getElementById("username_error").innerHTML="please enter a username";
		return;
	}
	
	if(!re.test(username)){
		document.getElementById("username_error").innerHTML="username must not contain special characters";
		return;
	}
	
	if(username.length > 20){
		document.getElementById("username_error").innerHTML="username must not contain more than 20 characters";
		return;
	}
}

function username_onblur(){
	var username = reg.username.value;
	
	if(username=="")
	{
		document.getElementById("username_error").innerHTML="please enter a username";
		return;
	}
}

//Firstname
function firstname_keyup(){
	var firstname = reg.firstname.value;
	var re = /^[\w ]+$/; 

	document.getElementById("firstname_error").innerHTML="";
	
	if(firstname=="")
	{
		document.getElementById("firstname_error").innerHTML="please enter a firstname";
		return;
	}
	
	if(!re.test(firstname)){
		document.getElementById("firstname_error").innerHTML="firstname must not contain special characters";
		return;
	}
	
	if(firstname.length > 20){
		document.getElementById("firstname_error").innerHTML="firstname must not contain more than 20 characters";
		return;
	}
}

function firstname_onblur(){
	var firstname = reg.firstname.value;
	
	if(firstname=="")
	{
		document.getElementById("firstname_error").innerHTML="please enter a firstname";
		return;
	}
}

//Lastname
function lastname_keyup(){
	var lastname = reg.lastname.value;
	var re = /^[\w ]+$/; 

	document.getElementById("lastname_error").innerHTML="";
	
	if(lastname=="")
	{
		document.getElementById("lastname_error").innerHTML="please enter a lastname";
		return;
	}
	
	if(!re.test(lastname)){
		document.getElementById("lastname_error").innerHTML="lastname must not contain special characters";
		return;
	}
	
	if(lastname.length > 20){
		document.getElementById("lastname_error").innerHTML="lastname must not contain more than 20 characters";
		return;
	}
}

function lastname_onblur(){
	var lastname = reg.lastname.value;
	
	if(lastname=="")
	{
		document.getElementById("lastname_error").innerHTML="please enter a lastname";
		return;
	}
}

//Password
function pass_keyup(){	
	var password = reg.password.value;
	var re = /^[a-zA-Z0-9]+$/;
	
	document.getElementById("password_error").innerHTML="";
	
	if(password=="")
	{
		document.getElementById("password_error").innerHTML="please enter a password";
		return;
	}
	
	if(!re.test(password)){
		document.getElementById("password_error").innerHTML="password must contain only letters and numbers";
		return;
	}
}

function pass_onblur(){
	var password = reg.password.value;
	var re = /^[a-zA-Z0-9]+$/;
	
	if(password=="")
	{
		document.getElementById("password_error").innerHTML="please enter a password";
		return;
	}
	
	if(re.test(password) && password.length < 8){
		document.getElementById("password_error").innerHTML="password must be at least 8 characters";
		return;
	}
}

//Password_again
function con_pass_keyup(){
	var con_pass = reg.password_again.value;
	var password = reg.password.value;
	var re = /^[a-zA-Z0-9]+$/;
	
	document.getElementById("password_again_error").innerHTML="";
	
	if(password.length >= 8 && re.test(password) && con_pass == ""){
		document.getElementById("password_again_error").innerHTML="please confirm your password";
		return;
	}
}

function con_pass_onblur(){
	var con_pass = reg.password_again.value;
	var password = reg.password.value;
	var re = /^[a-zA-Z0-9]+$/;
	
	if(password.length >= 8 && re.test(password) && con_pass != password){
		document.getElementById("password_again_error").innerHTML="please confirm your password";
		return;
	}
}

//Email
function email_keyup(){
	var email = reg.email.value;
	var re = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	
	document.getElementById("email_error").innerHTML="";
	
	if(email==""){
		document.getElementById("email_error").innerHTML="please enter your email address";
		return;
	}
}


function email_onblur(){
	var email = reg.email.value;
	var re = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	
	if(email==""){
		document.getElementById("email_error").innerHTML="please enter your email address";
		return;
	}
	
	if(!re.test(email)){
		document.getElementById("email_error").innerHTML="please enter a valid email address";
		return;
	}
}