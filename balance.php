<?php

session_start();


if(!isset($_SESSION['loginIn'])){
	
	header('Location: index.php');
	exit();
	

}
		$successful_validation = true;
		$incomes_sum = 0;
		$expenses_sum = 0;
		
		if(!isset($_GET['option'])){
			$option = 1;
		}
		if(isset($_GET['option'])){
			$option = $_GET['option'];
		}
		if(isset($_POST['firstDate']) || isset($_POST['secondDate'])){
			$option = 4;
		}

		
			switch($option){
			case 1: //current month
				$beginCurMonth = date("Y-m-01");
				$endCurMonth = date("Y-m-t");				
				$date1 = $beginCurMonth;
				$date2 = $endCurMonth;	
				break;
			case 2: //previous month
				$beginPrevMonth = date("Y-m-01", strtotime ("-1 month"));
				$endPrevMonth = date("Y-m-t", strtotime ("-1 month"));				
				$date1 = $beginPrevMonth;
				$date2 = $endPrevMonth;		
				break;
			case 3: //current year
				$beginCurYear = date("Y-01-01");
				$endCurYear = date("Y-12-t");					
				$date1 = $beginCurYear;
				$date2 = $endCurYear;	
				break;
			case 4: //nonstandard
				if(!isset($_POST['firstDate'])){
					$beginDate = date("Y-m-d");
				} else {
					$beginDate = $_POST['firstDate'];
				}
				if(!isset($_POST['secondDate'])){
					$endDate = date("Y-m-d");
				} else {
					$endDate = $_POST['secondDate'];
				}
				if($beginDate > $endDate || $endDate < $beginDate){
					$successful_validation = false;
					$_SESSION['dateError'] = 'Błędny przedział czasowy!';
					break;
				} else {
					$date1 = $beginDate;
					$date2 = $endDate;	
				}
				break;
		}
		
				
				
			 
 
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

			$db_connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($db_connection->connect_errno!=0) {
				throw new Exception(mysqli_connect_errno());
				
			}
			else {
				if($successful_validation){
					$user_id = $_SESSION['id'];
					$incomes_sql = "SELECT name, amount FROM incomes, incomes_category_default WHERE user_id = '$user_id' AND income_category_assigned_to_user_id = incomes_category_default.id AND date_of_income BETWEEN '$date1' AND '$date2'";
					$incomes = $db_connection->query($incomes_sql);
					
					$expenses_sql = "SELECT name, amount FROM expenses, expenses_category_default WHERE user_id = '$user_id' AND expense_category_assigned_to_user_id = expenses_category_default.id AND date_of_expense BETWEEN '$date1' AND '$date2'";
					$expenses = $db_connection->query($expenses_sql);
				}
					
			}
			
				$db_connection->close();
				
 

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
		<div class="navbar logoStyle mb-1">
		
		<h1>BUDŻET PERSONALNY</h1>
		
		</div>
	</header>
	
	<article>
	
		<div class="container balanceForm">
	
			<div class="row">
			
				<h2 style="text-align: center;">Bilans</h2>
				
			
				
					<div class="col-12 mb-5 mt-2" style="height: 50px;">

					<div class="period">
							<a href="balance.php?option=1">Bieżący miesiąc</a>
							<a href="balance.php?option=2">Poprzedni miesiąc</a>
							<a href="balance.php?option=3">Bieżący rok</a>
							<a href="#myModal" data-bs-toggle="modal" >Niestandardowy</a>	
					</div>
					
					</div>
								
					
					<div style="clear:both;"></div>
				
						<div class="col-xl-6 text-center leftPanel">
							<div>PRZYCHODY</div>
							<table>
							<tr>
								<th>Kategoria</th>
								<th>Kwota</th>
							</tr>
							<?php
							if($successful_validation){
								while($row = $incomes->fetch_assoc())
								{
								echo "<tr>";
								echo "<td>" . $row['name'] . "</td>";
								echo "<td>" . $row['amount'] . "</td>";
								echo "</tr>";
								$incomes_sum += $row['amount'];
								}
							}else{
								
								echo "<tr>";
								echo "<td></td>";
								echo "</tr>";
								
							}
								?>
						</table> 
						
						SUMA: <?php 
							echo round($incomes_sum, 2). " zł";
							?>
						</div>
					  
						<div class="col-xl-6 text-center rightPanel">
						<div>WYDATKI</div>
							<table>
							<tr>
								<th>Kategoria</th>
								<th>Kwota</th>
							</tr>
								<?php
							if($successful_validation){
								while($row = $expenses->fetch_assoc())
								{
								echo "<tr>";
								echo "<td>" . $row['name'] . "</td>";
								echo "<td>" . $row['amount'] . "</td>";
								echo "</tr>";
								$expenses_sum += $row['amount'];
								}
							}else{
								
								echo "<tr>";
								echo "<td></td>";
								echo "</tr>";
								
							}
								?>
						</table> 
						SUMA: <?php 
						echo round($expenses_sum, 2). " zł";
						?>
						</div>
						<div class="col-12">
				
							<a href="mainMenu.php" class="btn cancelButtonbg mt-2 mb-2">WRÓĆ</a>
				
						</div>
				<?php
					if (isset($_SESSION['dateError']))
					{
						echo '<div class="dateError" style="color:red; text-shadow: 2px 2px 4px black; font-size:25px; text-align:center; margin-top: 30px;">'.$_SESSION['dateError'].'</div>';
						unset($_SESSION['dateError']);
					}
					?>
			</div>
		</div>
							<!--Modal-->
							<div class="modal fade text-body" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel">Wybierz przedział czasowy</h4>
											<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">×</span>
											</button>
										</div>
										<form method="post" action="balance.php" >
											<div class="modal-body text-center mt-3 mb-3">
												<div id="selectPeriod">	
													od <input type="date" name="firstDate" id="dateBegin">
													do <input type="date" name="secondDate" id="dateEnd">
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-bs-dismiss="modal">Anuluj</button>
												<button type="submit" class="btn btn-primary" >Pokaż</button>
											</div>
										</form>
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