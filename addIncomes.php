<?php


session_start();


if(!isset($_SESSION['loginIn'])){
	
	header('Location: index.php');
	exit();
	
}

  if (isset($_POST['amount'])) {
	  
    $successful_validation = true;

    $amount = $_POST['amount'];
	
	if($amount <= 0){
		$successful_validation = false;
		$_SESSION['e_validation'] = "Kwota przychodu nie może wynosić 0zł";
	}
	
    if ((!(preg_match('/^[0-9]{1,20}$/', $amount))) && (!(preg_match('/^[0-9]{1,20}+\.+[0-9]{1,2}$/', $amount))) && (!(preg_match('/^[0-9\+]{1,20}+\,+[0-9\+]{1,2}$/', $amount)))) {
      $successful_validation = false;
      $_SESSION['e_validation'] = "Niepoprawny format kwoty!";
    }
    else {
      if (preg_match('/^[0-9]{1,20}+\,+[0-9]{1,2}$/', $amount)) {
        $amount = str_replace(",",".",$amount);
      }
    }

    
    $date = $_POST['date'];
	

		if(!(preg_match('/^[0-9]{4}+\-+[0-9]{1,2}+\-+[0-9]{1,2}$/', $date))) {
		  $successful_validation = false;
		  $_SESSION['e_validation'] = "Data musi być w formacie: RRRR-MM-DD";
		}
		else {
			
		  $year = substr($date, 0, 4);
		  $month = substr($date, 5, 2);
		  $day = substr($date, 8, 2);
		  
		  if(!checkdate($month, $day, $year)) {
			$successful_validation = false;
			$_SESSION['e_validation'] = "Niepoprawna data!";
		  }
		  
		  if($year < 2001) {
			$successful_validation = false;
			$_SESSION['e_validation'] = "Data nie może być wcześniejsza jak 2001 rok!";
		  }
		  
		  else {
			  
			$currentdate = date('Y-m-d');
			$currentyear = substr($currentdate, 0, 4);
			$currentmonth = substr($currentdate, 5, 2);
			$currentday = substr($currentdate, 8, 2);
		  
			if($year > $currentyear) {
			  $successful_validation = false;
			  $_SESSION['e_validation'] = "Data nie może być z przyszłości!";
			}
			
			elseif($year == $currentyear) {
			  if($month > $currentmonth) {
				$successful_validation = false;
				$_SESSION['e_validation'] = "Data nie może być z przyszłości!";
			  }
			  
			  elseif($month = $currentmonth) {
				if($day > $currentday) {
				  $successful_validation = false;
				  $_SESSION['e_validation'] = "Data nie może być z przyszłości!";
			
			}
          }
        }
      }
    }

     $category_id = $_POST['category'];
 
    $comment = $_POST['comment'];


    require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

    try {
			$db_connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($db_connection->connect_errno!=0) {
				throw new Exception(mysqli_connect_errno());
			}
			else {
				if ($successful_validation==true) {
					
					$user_id = $_SESSION['id'];
					
					$add_income = "INSERT INTO incomes VALUES (NULL, '$user_id', '$category_id', '$amount', '$date', '$comment')";

					if ($db_connection->query("$add_income")) {
						
						$_SESSION['successful_operation'] = true;
						
						$_SESSION['comunity']="Dodano przychód";
						
					} else {
						throw new Exception($db_connection->error);
					}
							
				}
				
				$db_connection->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<div class="error text-center">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</div>';
			echo '<br />Informacja developerska: '.$e;
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
	
		<div class="container">
			
			<div class="row justify-content-md-center mt-3">
			
				<div class="col-sm-10 col-md-6 col-lg-5 text-center formstyle">
					
					<h2>DODAJ PRZYCHÓD</h2>
					
					<form method="post">

					<div class="form-group mt-4 right-text-styling w-75 mx-auto">
						<label for="inputAmount">Kwota</label>
						<input type="number" class="form-control" id="inputAmount" step="0.01" value="0.00" name="amount" required>
					  </div>
					  
					  <div class="form-group mb-3 mt-2 right-text-styling w-75 mx-auto">
						<label for="theDate">Data</label>
						<input type="date" class="form-control" id="theDate" name="date" required>
					  </div>
						 
							<div class="category border border-white right-text-styling w-75 mx-auto">
							
							Kategoria:
							
								<div class="formCategory"><label><input class="form-check-input" type="radio" name="category" value="1" checked> Wynagrodzenie </label></div>

								<div class="formCategory"><label><input class="form-check-input" type="radio" name="category" value="2"> Odsetki bankowe </label></div>
								
								<div class="formCategory"><label><input class="form-check-input" type="radio" name="category" value="3"> Sprzedaż allegro </label></div>
								
								<div class="formCategory"><label><input class="form-check-input" type="radio" name="category" value="4"> Inne </label></div>
								
							</div>
							
						<div class="category">
						
							<div class="form-group">
							<textarea class="form-control right-text-styling w-75 mx-auto" id="comment" rows="3" cols="25" name="comment" placeholder="Komentarz (opcjonalnie)"></textarea>
							</div>
							
						</div>
						
							<button type="submit" class="btn buttonbg mt-2">DODAJ</button>
							<a href="mainMenu.php" class="btn cancelButtonbg mt-2">WRÓĆ</a>
							
							<div style="clear:both;"></div>
						
					</form>
				<?php
					if (isset($_SESSION['comunity']))
					{
						echo '<div class="comunity" style="color:#00e617; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 30px;">'.$_SESSION['comunity'].'</div>';
						unset($_SESSION['comunity']);
					}
					if (isset($_SESSION['e_validation']))
					{
						echo '<div class="e_date" style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 30px;">'.$_SESSION['e_validation'].'</div>';
						unset($_SESSION['e_validation']);
					}
					if (isset($_SESSION['e_validation']))
					{
						echo '<div class="e_validation" style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 30px;">'.$_SESSION['e_validation'].'</div>';
						unset($_SESSION['e_validation']);
					}
					if (isset($_SESSION['e_validation']))
					{
						echo '<div class="e_validation" style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 30px;">'.$_SESSION['e_validation'].'</div>';
						unset($_SESSION['e_validation']);
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

	<script src="currentDate.js"></script>

</html>