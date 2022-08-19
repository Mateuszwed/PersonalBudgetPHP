<?php

ini_set('display_errors', 1); 
error_reporting(E_ALL);

	session_start();
	
	if((!isset($_POST['email'])) && (!isset($_POST['password']))){
		
		header('Location: index.php');
		exit();
		
	}
	
	require_once "connect.php";
	
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	
	if($connect->connect_errno!=0){
		
		echo "Error: ".$connect->connect_errno;
		
	}else{
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$email = htmlentities($email, ENT_QUOTES, "UTF-8");
		
		if($result = @$connect->query(sprintf("SELECT * FROM users WHERE email='%s'",
		mysqli_real_escape_string($connect, $email))))
		
		{
			
			$how_many = $result->num_rows;
			if($how_many>0){
				
				$row = $result->fetch_assoc();
				
				if (password_verify($password, $row['password']))
				{
				
				$_SESSION['loginIn'] = true;
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['password'] = $row['password'];
				
				unset($_SESSION['loginError']);
				unset($_SESSION['accountSuccess']);
				$result->free_result();
				header('Location: mainMenu.php');
				}
				
				else 
					
				{
					$_SESSION['loginError'] = '<div style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top:10px;">Nieprawidłowy login lub hasło!</div>';
					header('Location: index.php');
				}
				
			}else{
				
				
					$_SESSION['loginError'] = '<div style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top:10px;">Nieprawidłowy login lub hasło!</div>';
					header('Location: index.php');
				
				
			}
			
		}
		$connect->close();
		
	}
	

?>