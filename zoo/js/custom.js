function login() {
	if (localStorage.user_id) {
		$('.loginButton').attr('title','Logout');
		$('.loginButton').attr('href','#');
		$('.userButton').show();
	} else {
		$('.userButton').hide();
	}
}
login();

$('.loginButton').click(function (){
	if (localStorage.user_id) {
		localStorage.removeItem('user_id');
		$('.loginButton').attr('title','User Login / Register');
		$('.loginButton').attr('href','register_login.html');
	}
});
$('.login').click(function (){
	var email = $('input[name=emailL]').val();
	var password = $('input[name=passL]').val();
	var str = 'email='+email+'&password='+password;
	$.ajax({  
		type: "POST",  
		url: "php/main.php?f=Login",  
		data: str, 
		dataType: "json", 
		success: function(data) {  
			if (data.response == 'success') {
				localStorage.setItem('user_id', data.id);
				$('.message').html('<div class="col-md-12 alert alert-success"><strong><i class="fa fa-thumbs-o-up"></i> Success!</strong> You successfully logged in.</div>');
				login();
			} else {
				$('.message').html('<div class="col-md-12 alert alert-danger"><strong><i class="fa fa-close"></i> Error!</strong> Invalid email address or password.</div>');
			}

		}
	});
});
$('.register').click(function (){
	var email = $('input[name=emailR]').val();
	var password = $('input[name=passR]').val();
	var fname = $('input[name=fnameR]').val();
	var lname = $('input[name=snameR]').val();
	var str = 'email='+email+'&password='+password+'&fname='+fname+'&lname='+lname;
	$.ajax({  
		type: "POST",  
		url: "php/main.php?f=Register",  
		data: str,
		dataType: "json", 
		success: function(data) {  
			if (data.response == 'success') {
				localStorage.setItem('user_id', data.id);
				$('.messager').html('<div class="col-md-12 alert alert-success"><strong><i class="fa fa-thumbs-o-up"></i> Success!</strong> You successfully registered your account and logged in.</div>');
				login();
			} else {
				$('.messager').html('<div class="col-md-12 alert alert-danger"><strong><i class="fa fa-close"></i> Error!</strong> Oops! something went wrong make sure you\'ve filled out the form correctly.</div>');
			}

		}
	});
});
$('.nameBtn').click(function (){
	var name = $('input[name=petname]').val()
	var user_id = localStorage.getItem('user_id')
	var animal_id = localStorage.getItem('animal_id')
	var str = 'name='+name+'&user_id='+user_id+'&animal_id='+animal_id;
	$.ajax({  
		type: "POST",  
		url: "php/main.php?f=nameAnimal",  
		data: str, 
		dataType: "json", 
		success: function(data) {  
			if (data.response == 'success') {
				$('.messager').html('<div class="col-md-12 alert alert-success"><strong><i class="fa fa-thumbs-o-up"></i> Success!</strong> You successfully adopted the animal!.</div>');
			} else {
				$('.messager').html('<div class="col-md-12 alert alert-danger"><strong><i class="fa fa-close"></i> Error!</strong> Oops! something went wrong make sure you\'ve filled out the form correctly.</div>');
			}

		}
	});
});