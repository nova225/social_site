<?php

//Declaring variables to prevent errors
$fname = ""; //first name
$lname = ""; //last name
$em = ""; //email
$em2 = ""; //email 2
$password = ""; // password
$password2 = ""; //password 2
$date = ""; //Sign up date
$error_array = array(); //Holds error messages

if (isset($_POST['register_button'])){

	//Registration form values

	//First name
	$fname = strip_tags($_POST['reg_fname']); //remove html tags
	$fname = str_replace(' ', '', $fname); //remove spaces
	$fname = ucfirst(strtolower($fname)); //uppercase first letter
	$_SESSION['reg_fname'] = $fname; //Stores first name into session variable

	//Last name
	$lname = strip_tags($_POST['reg_lname']); //remove html tags
	$lname = str_replace(' ', '', $lname); //remove spaces
	$lname = ucfirst(strtolower($lname)); //uppercase first letter
	$_SESSION['reg_lname'] = $lname; //Stores last name into session variable

	//Email
	$em = strip_tags($_POST['reg_email']); //remove html tags
	$em = str_replace(' ', '', $em); //remove spaces
	$em = ucfirst(strtolower($em)); //uppercase first letter
	$_SESSION['reg_email'] = $em; //Stores email into session variable

	//Email2
	$em2 = strip_tags($_POST['reg_email2']); //remove html tags
	$em2 = str_replace(' ', '', $em2); //remove spaces
	$em2 = ucfirst(strtolower($em2)); //uppercase first letter
	$_SESSION['reg_email2'] = $em2; //Stores email2 name into session variable

	//Password
	$password = strip_tags($_POST['reg_password']); //remove html tags

	//Password2
	$password2 = strip_tags($_POST['reg_password2']); //remove html tags

	//Date
	$date = date("Y-m-d"); //gets the current date

	if($em == $em2) {
		//Check if email is in valid format
		if (filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists
			$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0) {
				array_push($error_array, "Email already in use!<br>");
			}
		}
		else {
			array_push($error_array, "Invalid email format!<br>");
		}
	}
	else {
		array_push($error_array, "Emails don't match!<br>");
	}


	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters!<br>");
	}

	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array, "Your last name must be between 2 and 25 characters!<br>");
	}

	if($password != $password2) {
		array_push($error_array, "Your passwords do not match!<br>");
	}

	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers.<br>");
		}
	}

	if(strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Your password must be between 5 and 30 characters!<br>");
	}

	
	if(empty($error_array)) {
		$password = md5($password); //Encrypt password before sending to database

		//Generate username by concatenating first name and last name
		$username = strtolower($fname . "_" . $lname);
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");

		$i = 0;
		// if username exists add number to username
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++; //Add 1 to i
			$username = $username . "_" .$i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
		}

		//Profile picture assignment
		$rand = rand(1, 7); //Random number between 1 and 2

		if($rand == 1)
			$profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
		else if ($rand == 2)
			$profile_pic = "assets/images/profile_pics/defaults/head_amethyst.png";
		else if ($rand == 3)
			$profile_pic = "assets/images/profile_pics/defaults/head_carrot.png";
		else if ($rand == 4)
			$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
		else if ($rand == 5)
			$profile_pic = "assets/images/profile_pics/defaults/head_red.png";
		else if ($rand == 6)
			$profile_pic = "assets/images/profile_pics/defaults/head_pumpkin.png";
		else if ($rand == 7)
			$profile_pic = "assets/images/profile_pics/defaults/head_sun_flower.png";

		//salje podatke u db po redu kolumni kako su organizirane u db
		$query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

		//doda pozdravnu poruku u $error_array kada sve prodje
		array_push($error_array, "<span>You're all set! Go ahead and log in!</span><br>");

		//clear session variables
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";

	}

}
?>