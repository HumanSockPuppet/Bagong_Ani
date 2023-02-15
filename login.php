<!DOCTYPE html>
<html lang="en" >

<head>
	<meta charset="UTF-8">
	<title>Bagong Ani</title>  
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/login.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>  
</head>

<body>
	<?php
		include("connection/connect.php"); //INCLUDE CONNECTION
		error_reporting(0); // hide undefine index errors
		session_start(); // temp sessions
		// if button is submit
		if(isset($_POST['submit'])){
			$username = $_POST['username'];  //fetch records from login form
			$password = $_POST['password'];
			
			// if records were not empty
			if(!empty($_POST["submit"])){
				$loginquery ="SELECT * FROM users WHERE username='$username' && password='".md5($password)."'"; //selecting matching records
				$result=mysqli_query($db, $loginquery); //executing
				$row=mysqli_fetch_array($result);
				
				// if matching records in the array & if everything is right
				if(is_array($row)){
					$_SESSION["user_id"] = $row['user_id']; // put user id into temp session
					header("refresh:1;url=index.php"); // redirect to index.php page
				} 
				else{
					$message = "Invalid Username or Password!"; // throw error
				}
			}
		}
	?>
  
	<!-- Form Module-->
	<div class="center">
		<div class="container">		
			<div class="text">
				Login Form
			</div>
			<span style="color:red;"><?php echo $message; ?></span> 
			<span style="color:green;"><?php echo $success; ?></span>
			<form action="#" method="post">
				<div class="data">
					<label>Username</label>
					<input type="text"  name="username" required>
				</div>
				<div class="data">
					<label>Password</label>
					<input type="password" name="password" required>
				</div>
				<div class="forgot-pass">
					<a href="#">Forgot Password?</a>
				</div>
				<div class="btn">
					<div class="inner"></div>
					<button type="submit" id="buttn" name="submit" value="login">login</button>
				</div>
				<div class="signup-link">
					Not registered? <a href="signup.php">Signup now</a>
				</div>
				<br>
				<center><a class="img-logo" href="index.php" > <img class="img-rounded" src="images/bagong-ani-logo.png" style="width:200px" alt=""></a></center>
			</form>
		</div>
	</div>
	
  	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
</html>
