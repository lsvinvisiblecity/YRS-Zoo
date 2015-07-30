<?php
$servername = "localhost";
$username = "sicki_yrs";
$database = "sickie_yrs";
$password = "yrsyrs1";

// Create connection
$conn = new mysqli($servername, $username, $password, $database	);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error. "<br />");
} 

$api_key = 'ddb164498abbd102b40ffafb3abde7e6bf51618e';

reset($_REQUEST);
while(list($key, $val) = each($_REQUEST)) {
	$post_string .= $key.'='.$val.'&';
	$val = stripslashes($val);
	$val = ($val);
	$workString .= '&' .$key .'=' .$val."\n";
}

if(isset($_REQUEST['custom']) && !empty($_REQUEST['custom'])) {
	if($_REQUEST['payment_status'] == 'Completed') 	{	

		$sql = "SELECT * FROM `sickie_yrs`.`order_form` WHERE `user_id`=".$_REQUEST['custom'];
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();	

		$date = date("Y-n-j");
		$sql = "INSERT INTO `sickie_yrs`.`payments` (`id`, `user_id`, `payment_status`, `payment_id`, `payment_date`) VALUES (NULL, '{$_REQUEST['custom']}', '{$_REQUEST['payment_status']}', '{$_REQUEST['txn_id']}', '$date')";
		if ($conn->query($sql) === TRUE) { 
			try {
    			$clockwork = new Clockwork($api_key);
    			$message = array('to' =>'447803551575','message'=>'WOW! Thank you! Thanks for support, it will help us alot! <3');
    			$result = $clockwork->send($message);
			}
		} 
	}
}
?>