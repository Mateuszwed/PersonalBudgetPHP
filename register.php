
<?php

	session_start();
	
	if (isset($_POST['email']))
	{

		$successful_validation=true;
		
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$successful_validation=false;
			$_SESSION['error']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($password1!=$password2)
		{
			$successful_validation=false;
			$_SESSION['error']="Podane hasła nie są identyczne!";
		}	

		$security_password = password_hash($password1, PASSWORD_DEFAULT);
			
		
		$_SESSION['fr_username'] = $username;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$connect = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connect->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $connect->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($connect->error);
				
				$mail_numbers = $rezultat->num_rows;
				if($mail_numbers>0)
				{
					$successful_validation=false;
					$_SESSION['error']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				
				if ($successful_validation==true)
				{
					
					if ($connect->query("INSERT INTO users VALUES (NULL, '$username', '$security_password', '$email')"))
					{
						header('Location: index.php');
					}
					else
					{
						throw new Exception($connect->error);
					}
					
				}
				
				$connect->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		}
		
	}
	
	
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Budżet personalny</title>
	<meta name="description" content="Strona pozwoli Ci obliczyć swoje przychody oraz wydatki." />
	<meta name="keywords" content="budżet personalny, przychody, wydatki" />
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
	
	
</head>

<body class="d-flex flex-column min-vh-100">
	
	<header>
		
		<div class="navbar logoStyle mb-5">
		
		<h1>BUDŻET PERSONALNY</h1>
		
		</div>
		
	</header>
	
	<article>
	
		<div class="container-fluid">
	
			<div class="row text-center">

				<div class="col-sm-12 registerForm">
				
					<h2>REJESTRACJA</h2>
					
							
						<form method="post">
						
							<div><label> Imię <input class="textfield form-control" type="text" name="username" required /></label></div>
									
							<div><label> E-mail <input class="textfield form-control" type="email" name="email" required /></label></div>
							
							<div>
							<label> Hasło <input class="passField form-control" type="password" id="password" name="password1" required></label>
							<i id="visibilityBtn"><span id="icon" class="material-symbols-outlined eyeStyle">visibility</span></i>
							</div>
							
							<div>
							<label> Powtórz hasło <input class="passField form-control" type="password" id="password2" name="password2" required></label>
							<i id="visibilityBtn2"><span id="icon2" class="material-symbols-outlined eyeStyle">visibility</span></i>
							</div>
									
							<button type="submit" class="btn buttonbg mt-4">ZAŁÓŻ KONTO</button>
							
							<div id="goToLogin"><a href="index.php">Wróć do logowania</a></div>

						</form>
							<?php
								if (isset($_SESSION['error']))
								{
									echo '<div class="error" style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 30px;">'.$_SESSION['error'].'</div>';
									unset($_SESSION['error']);
								}
							?>		
				</div>
			</div>
		</div>
		
	</article>
	
	<footer class="mt-auto">
	
		<div class="text-center p-3 info" style="background-color: rgba(0, 0, 0, 0.2);">
			© 2022 Wszelkie prawa zastrzeżone</a>
		</div>
	
	</footer>
	
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>
	
	
	
</body>

	<script src="showHideRegister.js"></script>

</html>
