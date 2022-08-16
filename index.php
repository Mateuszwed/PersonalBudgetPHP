
<?php

session_start();

	if((isset($_SESSION['loginIn'])) && ($_SESSION['loginIn'] == true)){
		
		header('Location: mainMenu.php');
		exit();
		
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
			
				<div class="col-sm-12 loginForm">
				
					<h2>LOGOWANIE</h2>
							
					<form action="login.php" method="post">
								
						<div><label> E-mail <input class="textfield form-control" type="email" name="email" required></label></div>
								 
						<div>
							<label> Hasło <input class="passField form-control" type="password" id="password" name="password" required></label>
							<i id="visibilityBtn"><span id="icon" class="material-symbols-outlined eyeStyle">visibility</span></i>
						</div>

								
						<button type="submit" class="btn buttonbg mt-4">ZALOGUJ</button>
							
						<div id="goToRegister">
								Jeśli nie masz jeszcze konta <a href="register.php">Zarejestruj się</a>
						</div>
				
					</form>
					<?php
						if(isset($_SESSION['loginError']))
						echo $_SESSION['loginError'];
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

	<script src="showHideLogin.js"></script>
	
</html>
