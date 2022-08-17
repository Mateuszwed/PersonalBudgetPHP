
<?php

session_start();

if(!isset($_SESSION['loginIn'])){
	
	header('Location: index.php');
	exit();
	
}

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Budżet personalny</title>
	<meta name="description" content="Strona pozwoli Ci obliczyć przychody oraz wydatki." />
	<meta name="keywords" content="budżet personalny, przychody, wydatki" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">	
	
</head>

<body class="d-flex flex-column min-vh-100">
	
	<header>
		<div class="navbar logoStyle mb-5">
		
		<h1>BUDŻET PERSONALNY</h1>
		
		</div>
	</header>
	
	<article>
	
		<div id="container-fluid">
	
			<div class="row mainMenu text-center">
			
				<h2>MENU GŁÓWNE</h2>
				

				 <div class="option">
				 <a href="addIncomes.php" class="btn buttonbg mt-2">Dodaj przychód</a>
				 </div>
				 
				 <div class="option">
				 <a href="addExpenses.php" class="btn buttonbg mt-2">Dodaj wydatek</a>
				 </div>
				 
				 <div class="option">
				 <a href="balance.php" class="btn buttonbg mt-2">Przeglądaj bilans</a>
				 </div>
				 
				 <div class="option">
				 <a href="#" class="btn buttonbg mt-2">Ustawienia</a>
				 </div>
				 
				 <div class="optionLogout">
				 <a href="logout.php" class="btn buttonbg mt-2">Wyloguj</a>
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

</html>