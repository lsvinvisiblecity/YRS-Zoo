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
$sql = "SELECT * FROM `sickie_yrs`.`animals`";
$result = $conn->query($sql);
$arr = array();
$i=0;
while($row = $result->fetch_assoc()) {
	$arr[$i] = array('id' => $row['id'], 'name' => $row['name'], 'video_url' => $row['video_url'], 'pic1'=> $row['pic1'], 'pic2'=> $row['pic2'], 'pic3'=> $row['pic3'], 'pic4'=> $row['pic4'], 'bio'=> $row['bio']);
	$i++; 
}
?>
<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>Sponzoo An Animal</title>	

		<meta name="keywords" content="" />
		<meta name="description" content="Sponzoo an Animal!">
		<meta name="author" content="">
		<meta property="og:title" content="title" />
		<meta property="og:description" content="description" />
		<meta property="og:image" content="thumbnail_image" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="plugins/bootstrap/bootstrap.css">
		<link rel="stylesheet" href="plugins/fontawesome/css/font-awesome.css">
		<link rel="stylesheet" href="plugins/owlcarousel/owl.carousel.min.css" media="screen">
		<link rel="stylesheet" href="plugins/owlcarousel/owl.theme.default.min.css" media="screen">
		<link rel="stylesheet" href="plugins/swipebox/css/swipebox.min.css">
		<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
		<div class="body">
			<header id="header">
				<div class="container">
					<ul>
						<li><a href="index.html" title="Home"><img class="logo" src="img/logo.png"></a></li>
						<li><a href="zookeeper_bio.html" title="Zookeeper Bio"><i class="fa fa-file-text"></i></a></li>
						<li><a href="zookeeper_blog.html" title="Zookeeper Blog"><i class="fa fa-envelope"></i></a></li>
						<li><a href="register_login.html" title="User Login / Register" class="loginButton"><i class="fa fa-lock"></i></a></li>
						<li><a href="user_profile.html" title="User Profile" class="userButton"><i class="fa fa-user"></i></a></li>
					</ul>
				</div>
			</header>
			<content id="main_body">
				<div class="container">
					<div class="owl-carousel">
						<?php
						foreach($arr as $key => $value) {
						?>
						<div class="item">
						<span>
							<div class="image showMorePictures">
								<img src="<?php echo $value['pic1']; ?>">
							</div>
							<div class="morePictures">
								<div style="display:none;">
									<a href="<?php echo $value['pic1']; ?>" class="swipebox" rel="gallery-'+i">
										<img src="<?php echo $value['pic1']; ?>">
									</a>
								</div>
								<div class="col-md-4">
									<a href="<?php echo $value['pic2']; ?>" class="swipebox" rel="gallery-'+i">
										<img src="<?php echo $value['pic2']; ?>">
									</a>
								</div>
								<div class="col-md-4">
									<a href="<?php echo $value['pic3']; ?>" class="swipebox" rel="gallery-'+i">
										<img src="<?php echo $value['pic3']; ?>">
									</a>
								</div>
								<div class="col-md-4">
									<a href="<?php echo $value['pic4']; ?>" class="swipebox" rel="gallery-'+i">
										<img src="<?php echo $value['pic4']; ?>">
									</a>
								</div>
							</div>
							<p class="title"><?php echo $value['name']; ?></p>
							<div class="moreInfo">
								<div class="bio">
									<p><?php echo $value['bio']; ?></p>
								</div>
								<div class="youtube">
								    <iframe width="560" height="349" src="https://www.youtube.com/embed/<?php echo $value['video_url']; ?>" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
							<div class="buttons">
								<a href="#" class="btn btn-sm btn-primary fb"><i class="fa fa-facebook"></i></a>
								<a href="#" class="btn btn-lg btn-success order" id="<?php echo $value['id']; ?>"><i class="fa fa-check"></i></a>
								<a href="#" class="btn btn-lg btn-warning showMore"><i class="fa fa-arrow-down rotate"></i></a>
								<a href="#" class="btn btn-sm btn-primary twitter"><i class="fa fa-twitter"></i></a>
							</div>
						</span>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			</content>
		</div>		
		<footer id="footer">
			<div class="container">
				<p>Spon<span>zoo</span> An <span>Animal</span> &copy; 2015. All rights reserved.</p>
			</div>
		</footer>
	</body>
	<script src="plugins/jquery/jquery.js"></script>
	<script src="plugins/bootstrap/bootstrap.js"></script>
	<script src="plugins/owlcarousel/owl.carousel.js"></script>
	<script src="plugins/swipebox/js/jquery.swipebox.min.js"></script>
	<script>
		$('.swipebox').swipebox();
		var owl = $('.owl-carousel');
		owl.owlCarousel({
			margin: 10,
			loop: true,
			nav: false,
			dots: false,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 2
				},
				1000: {
					items: 3
				}
			}
		});
		$('.showMore').click(function() {
			var information = $(this).closest(".buttons").prev(".moreInfo");
			if (information.is(":hidden")) {
				information.slideDown("slow");
				$(this).find("i").toggleClass("down");
			} else {
				information.slideUp("slow");
				$(this).find("i").toggleClass("down");
			}
		});
		
		$('.showMorePictures').click(function() {
			var information = $(this).next();
			if (information.is(":hidden")) {
				information.slideDown("slow");
			} else {
				information.slideUp("slow");
			}
		});	
		
		$('.order').click(function() {
			var id = $(this).attr("id");
			localStorage.setItem("animal_id", id); 
			window.location.assign("order_new.html")
		});
		
		$('.twitter').click(function(){
			var animal = $(this).closest(".buttons").prev(".moreInfo").prev(".title").html();
			var x = animal.charAt(0).toUpperCase();
			if(x=="A"||x=="E"||x=="O"||x=="U"||x=="I"){
				animal = "an" + "%20" + animal;
			} else {
				animal = "a" + "%20" + animal;
			}
			window.location.assign("https://twitter.com/intent/tweet?text=I%20adopted%20"+animal+"!%20%20You%20can%20too%20by%20going%20to%20http://yrs.sickie.eu!");
		});
		
		$('.fb').click(function() {
			var animal = $(this).closest(".buttons").prev(".moreInfo").prev(".title").html();
			var x = animal.charAt(0).toUpperCase();
			if(x=="A"||x=="E"||x=="O"||x=="U"||x=="I"){
				animal = "an" + "%20" + animal;
			} else {
				animal = "a" + "%20" + animal;
			}
			window.location.assign("http://www.facebook.com/sharer.php?s=100&amp;&p[url]=http://yrs.sickie.eu&p[images][0]=&p[title]=Sponzoo&p[summary]=I%20adopted%20"+animal+"!%20%20You%20can%20too%20by%20going%20to%20http://yrs.sickie.eu!");
		});
		
    </script>
	<script src="js/custom.js"></script>
</html>