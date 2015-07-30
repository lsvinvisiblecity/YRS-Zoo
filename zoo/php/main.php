<?php
require 'class-Clockwork.php';
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

if (isset($_GET['f']) && $_GET['f'] == 'Login') {
	$email = $_POST["email"];
	$pass = $_POST["password"];
	$pass = md5($pass);
	$sql = "SELECT * FROM `sickie_yrs`.`users` WHERE `email`='$email' AND `pass`='$pass'";
	$result = $conn->query($sql) or trigger_error($conn->error." [$sql]");
    if($result->num_rows > 0) {
    	$row = $result->fetch_assoc();
		$arr = array('response'=>'success', 'id'=>$row['id']);
    } else {
		$arr = array('response'=>'failed');
	}	
	echo json_encode($arr);
} else if (isset($_GET['f']) && $_GET['f'] == 'Register') {
	$email = $_POST["email"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$pass = $_POST["pass"];
	$tel = $_POST["telR"];
	$name = $fname." ".$lname;
	$pass = md5($pass);
	$sql = "INSERT INTO `sickie_yrs`.`users` (`id`, `name`, `pass`, `email`, `tel`) VALUES (NULL, '$name', '$pass', '$email', '$tel')";
	if ($conn->query($sql) === TRUE) {
		$id =  $conn->insert_id;		
		$arr = array('response'=>'success', 'id'=>$id);
    } else {
		$arr = array('response'=>'failed');
	}	
	echo json_encode($arr);
} else if (isset($_GET['f']) && $_GET['f'] == 'getBio') {
	$sql = "SELECT * FROM `sickie_yrs`.`keeper_bios`";
	$result = $conn->query($sql);
	$arr = array();
	$i=0;
	while($row = $result->fetch_assoc()) {
		$arr[$i] = array('id' => $row['id'], 'name' => $row['name'], 'bio' => $row['biography'], 'img'=> $row['image']);
		$i++;
    }
	echo json_encode($arr);
	
} else if (isset($_GET['f']) && $_GET['f'] == 'getBlogs') {
	$sql = "SELECT * FROM `sickie_yrs`.`keeper_blogs`";
	$result = $conn->query($sql);
	$arr = array();
	$i=0;
	while($row = $result->fetch_assoc()) {
		$arr[$i] = array('id' => $row['id'], 'name' => $row['keeper_name'], 'text' => $row['text'], 'title'=>$row['title'], 'date'=>$row['date']);
		$i++;
    }
	echo json_encode($arr);
	
//get animals
} else if(isset($_GET['f']) && $_GET['f'] == 'getData'){
	$sql = "SELECT * FROM `sickie_yrs`.`animals`";
	$result = $conn->query($sql);
	$arr = array();
	$i=0;
	while($row = $result->fetch_assoc()) {
		$arr[$i] = array('id' => $row['id'], 'name' => $row['name'], 'video_url' => $row['video_url'], 'pic1'=> $row['pic1'], 'pic2'=> $row['pic2'], 'pic3'=> $row['pic3'], 'pic4'=> $row['pic4'], 'bio'=> $row['bio']);
		$i++; 
	}
	echo json_encode($arr);
} else if(isset($_GET['f']) && $_GET['f'] == 'nameAnimal'){
		$name = $_POST["name"];
		$user_id = $_POST["user_id"];
		$animal_id = $_POST["animal_id"];
		$sql = "INSERT INTO `sickie_yrs`.`order_form` (`id`, `user_id`, `animal_id`, `name_picked`) VALUES (NULL, '$user_id', '$animal_id', '$name')";
		if ($conn->query($sql) === TRUE) {
			$arr = array('response'=>'success');
			$sql = "SELECT * FROM `sickie_yrs`.`users` WHERE `id`=".$user_id;
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();

			$number = explode("07", $row['tel']);
			if ($number[0] == "07") {
				$sendto = '447'.$number[1];
			} else {
				$sendto = $row['tel'];
			}
			$message = 'Hey!! This is '.$name.'. Thank you for supporting me and hope we become best friends <3';
    		$clockwork = new Clockwork($api_key);
    		$message = array('to' =>$sendto,'message'=>$message);
    		$result = $clockwork->send($message);
		} else {
			$arr = array('response'=>'failed');
		}	
		echo json_encode($arr);
		
} else if (isset($_GET['f']) && $_GET['f'] == 'getAnimals') {
	$id = $_GET['id'];
	$sql = "SELECT * FROM `sickie_yrs`.`order_form` WHERE `user_id`=".$id;
	$result = $conn->query($sql);
	$arr = array();
	$i=0;
	while($row = $result->fetch_assoc()) {
		$query = "SELECT * FROM `sickie_yrs`.`animals` WHERE `id`=".$row['animal_id'];
		$name = $conn->query($query);
		$rows = $name->fetch_assoc();
		$arr[$i] = array('name'=>$row['name_picked'], 'animal'=>$rows['name']);
		$i++;
    }
	echo json_encode($arr);

} else if (isset($_GET['f']) && $_GET['f'] == 'getPayments') {
	$id = $_GET['id'];
	$sql = "SELECT * FROM `sickie_yrs`.`payments` WHERE `user_id`=".$id;
	$result = $conn->query($sql);
	$arr = array();
	$i=0;
	while($row = $result->fetch_assoc()) {
		$arr[$i] = array('name'=>$row['payment_id']);
		$i++;
    }
	echo json_encode($arr);
}







$conn->close();
?>