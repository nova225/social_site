<?php 

require 'config/config.php'; 

if (isset($_SESSION ['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}
else {
	header("Location: register.php");
}

?>

<html>
<head>
	<title>Welcome to Social</title>

	<!-- Javascript -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	

	<!-- CSS -->

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


</head>
<body>

		<div class="top_bar">
			
			<div class="logo">
				
				<a href="index.php">Social!</a>

			</div>

			<nav>
				<a href="<?php echo $userLoggedIn; ?>">
					<?php echo $user['first_name']; ?>
				</a>
				<a href="index.php">
					<i class="fas fa-home fa-lg"></i>
				</a>
				<a href="#">
					<i class="fas fa-user-friends fa-lg"></i>
				</a>
				<a href="#">
					<i class="fas fa-envelope fa-lg"></i>
				</a>
				<a href="#">	
					<i class="fas fa-bell fa-lg"></i>
				</a>
				<a href="#">
					<i class="fas fa-cog fa-lg"></i>
				</a>
				<a href="includes/handlers/logout.php">
					<i class="fas fa-sign-out-alt fa-lg"></i>
				</a>

			</nav>

		</div>

	<div class="wrapper"> <!--ovaj div1 je zatvoren na dnu index.phpa -->
	



