
<?php

session_start();

if(!isset($_SESSION['loginIn'])){
	
	header('Location: index.php');
	exit();
	
}

  if (isset($_POST['amount'])) {
    $successful_validation = true;


    $amount = $_POST['amount'];

    if ((!(preg_match('/^[0-9]{1,20}$/', $amount))) && (!(preg_match('/^[0-9]{1,20}+\.+[0-9]{1,2}$/', $amount))) && (!(preg_match('/^[0-9\+]{1,20}+\,+[0-9\+]{1,2}$/', $amount)))) {
      $successful_validation = false;
      $_SESSION['e_amount'] = "Niepoprawny format kwoty!";
    }
    else {
      if (preg_match('/^[0-9]{1,20}+\,+[0-9]{1,2}$/', $amount)) {
        $amount = str_replace(",",".",$amount);
      }
    }

    
    $date = $_POST['date'];

    if(!(preg_match('/^[0-9]{4}+\-+[0-9]{1,2}+\-+[0-9]{1,2}$/', $date))) {
      $successful_validation = false;
      $_SESSION['e_date'] = "Data musi być w formacie: RRRR-MM-DD";
    }
    else {
      $year = substr($date, 0, 4);
      $month = substr($date, 5, 2);
      $day = substr($date, 8, 2);
      
      if(!checkdate($month, $day, $year)) {
        $successful_validation = false;
        $_SESSION['e_date'] = "Niepoprawna data!";
      }
      else {
        $currentdate = date('Y-m-d');
        $currentyear = substr($currentdate, 0, 4);
        $currentmonth = substr($currentdate, 5, 2);
        $currentday = substr($currentdate, 8, 2);
      
        if($year > $currentyear) {
          $successful_validation = false;
          $_SESSION['e_date'] = "Data nie może być z przyszłości!";
        }
        elseif($year == $currentyear) {
          if($month > $currentmonth) {
            $successful_validation = false;
            $_SESSION['e_date'] = "Data nie może być z przyszłości!";
          }
          elseif($month = $currentmonth) {
            if($day > $currentday) {
              $successful_validation = false;
              $_SESSION['e_date'] = "Data nie może być z przyszłości!";
            }
          }
        }
      }
    }

     $payment_id = $_POST['payment'];
	 
	 
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
					
					$add_expense = "INSERT INTO expenses VALUES (NULL, '$user_id', '$category_id', '$payment_id', '$amount', '$date', '$comment')";

					if ($db_connection->query("$add_expense")) {
						
						$_SESSION['successful_operation'] = true;
						
						$_SESSION['comunity']="Dodano wydatek";
						
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
	
		<div class="container-fluid">
	
			<div class="row text-center">
			
				<div class="col-sm-12 addBalanceForm">
					
					<h2>DODAJ WYDATEK</h2>
					
					<form method="post">
					
						<div><label> Kwota <input class="textfield form-control" type="number" step="0.01" value="0.00" name="amount" required></label></div>
						
						<div><label> Data <input id="theDate" class="textfield form-control" type="date" name="date" required></label></div>
						 
							<div class="category">
							
							Sposób płatności:
								<div class="formCategory"><label><input class="form-check-input" type="radio" name="payment" value="1" checked> Gotówka </label></div>

								<div class="formCategory"><label><input class="form-check-input" type="radio" name="payment" value="2" > Karta debetowa </label></div>
								
								<div class="formCategory"><label><input class="form-check-input" type="radio" name="payment" value="3" > Karta kredytowa </label></div>
								
							</div>
						
							<div class="category">
								<div><label>Kategoria<select name="category" class="form-select mt-1 mb-1">
								<option value="1" selected>Jedzenie</option>
								<option value="2" >Mieszkanie</option>
								<option value="3" >Transport</option>
								<option value="4" >Telekomunikacja</option>
								<option value="5" >Opieka zdrowotna</option>
								<option value="6" >Ubranie</option>
								<option value="7" >Higiena</option>
								<option value="8" >Dzieci</option>
								<option value="9" >Rozrywka</option>
								<option value="10" >Wycieczka</option>
								<option value="11" >Szkolenia</option>
								<option value="12" >Książki</option>
								<option value="13" >Oszczędności</option>
								<option value="14" >Na złotą jesień, czyli emeryturę</option>
								<option value="15" >Spłata długów</option>
								<option value="16" >Darowizna</option>
								<option value="17" >Inne wydatki</option>
								</select></label></div>
								
							</div>
						
						<div class="category">
							
							<div><label><textarea class="form-control" id="comment" name="comment" rows="3" cols="25" placeholder="Komentarz (opcjonalnie)"></textarea></label></div>
							
						</div>
						
							<button type="submit" class="btn buttonbg mt-2">DODAJ</button>
							<a href="mainMenu.php" class="btn cancelButtonbg mt-2">WRÓĆ</a>
							<div style="clear:both;"></div>
						
					</form>
					
				<?php
					if (isset($_SESSION['comunity']))
					{
						echo '<div class="comunity" style="color:#00e617; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 20px;">'.$_SESSION['comunity'].'</div>';
						unset($_SESSION['comunity']);
					}
					if (isset($_SESSION['e_date']))
					{
						echo '<div class="e_date" style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 20px;">'.$_SESSION['e_date'].'</div>';
						unset($_SESSION['e_date']);
					}
					
					if (isset($_SESSION['e_amount']))
					{
						echo '<div class="e_amount" style="color:red; text-shadow: 2px 2px 4px black; font-size:18px; margin-left:auto; margin-right:auto; margin-top: 20px;">'.$_SESSION['e_amount'].'</div>';
						unset($_SESSION['e_amount']);
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