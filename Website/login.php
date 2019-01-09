<?php
ini_set( 'session.cookie_httponly', 1 );
session_start();

if (isset($_POST["username"]) &&
    isset($_POST["password"])) {

    $user_name = $_POST["username"];
    $user_pass = $_POST["password"];

    $servername = "localhost";
    $username = "admin";
    $password = "P@ssw0rd";
    $db_name = 'challenge';

// Create connection
    $conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE username = '" . $user_name . "' AND password = '" . $user_pass . "' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // output data of each row
        $row = $result->fetch_object();
        session_regenerate_id(true);
        $message = $row->username;
        echo "<script type='text/javascript'>alert('$message');</script>";

        $token = sha1(uniqid(mt_rand(0,100000)));

        $_SESSION["username"] = $row->username;
        $_SESSION["name"] = $row->name;
        $_SESSION["token"] = $token;
        $_SESSION["amount"] = 1000;


        header('Location: '. 'blog.php');
        die();
    } else {
        $message = "Wrong Username or Password";

    }
    $conn->close();

}
else {
    $user_name = "";
    $user_pass = "";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>HackMe</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>

		<!-- Header -->
		<header id="header">
			<div class="container">

				<div class="navbar-header">
					<!-- Logo -->


					<!-- Mobile toggle -->
					<button class="navbar-toggle">
						<span></span>
					</button>
					<!-- /Mobile toggle -->
				</div>

				<!-- Navigation -->

				<!-- /Navigation -->

			</div>
		</header>
		<!-- /Header -->

		<!-- Hero-area -->
		<div class="hero-area section">

			<!-- Backgound Image -->
			<div class="bg-image bg-parallax overlay" style="background-image:url(./img/page-background.jpg)"></div>
			<!-- /Backgound Image -->

			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 text-center">
						<ul class="hero-area-tree">
							<li>Home</li>
							<li>Login</li>
						</ul>
						<h1 class="white-text">Login Page</h1>

					</div>
				</div>
			</div>

		</div>
		<!-- /Hero-area -->

		<!-- Contact -->
		<div id="contact" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<!-- contact form -->
					<div class="col-md-4">
						<div class="contact-form">
							<h4>Login</h4>
							<form action="login.php" method="POST">
								<input class="input" type="text" name="username" placeholder="Username">
								<input class="input" type="password" name="password" placeholder="Password">
								<button class="main-button icon-button pull-right" type="submit" id="submit">Login</button>
                                <?php if (isset($message)){ echo "<p style='color: red'>" . $message . "</p>";}?>
							</form>
						</div>
					</div>
					<!-- /contact form -->

				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /Contact -->

		<!-- Footer -->
		<footer id="footer" class="section">

			<!-- container -->


		</footer>
		<!-- /Footer -->

		<!-- preloader -->
<!--		<div id='preloader'><div class='preloader'></div></div>-->
		<!-- /preloader -->


		<!-- jQuery Plugins -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
		<script type="text/javascript" src="js/google-map.js"></script>
		<script type="text/javascript" src="js/main.js"></script>

	</body>
</html>
