<?php

if (!isset($_GET['action'])) {
	$_GET['action'] = '';
}
session_start();

switch($_GET['action']){

	case 'addTopping': 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 0;

		if (isset($_GET['topping']) && strlen(str_replace(' ', '', $_GET['topping'])) > 0 ) {
			if (!isset($_SESSION['toppings'])) {
				$_SESSION['toppings'] = array();
			}
			$_SESSION['toppings'][] = $_GET['topping'];
			$result['success'] = 1;
		} else {
			$result['success'] = 0;
			$result['errormsg'] = 'No Topping Entered';
		}

		echo json_encode($result);
		exit;
	break;

	case 'getToppings'; 
		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 1;
		$result['toppings'] = array();

		if (isset($_SESSION['toppings'])) {
			$result['toppings'] = $_SESSION['toppings'];
			$result['success'] = 1;
		}

		echo json_encode($result);
		exit;
	break;

	case 'deleteTopping':

		$result = array();
		$result['errormsg'] = '';
		$result['success'] = 0;

		$toppingsBefore = count($_SESSION['toppings']);
		$toppings = $_SESSION['toppings'];

		if(sizeof($_SESSION['toppings']) > 1){
			array_splice($_SESSION['toppings'], $_GET['toppingId'], 1);
		}else{
			unset($_SESSION['toppings']);
		}

		if(!isset($_SESSION['toppings'])){
			$result['success'] = 1;
			echo json_encode($result);
			return;
		}

		if(count($_SESSION['toppings']) < $toppingsBefore){
			$result['success'] = 1;
		}else{
			$result['errormsg'] = "The topping was not removed";
		}
		echo json_encode($result);
		exit;
	break;

	default: 
		printForm();
}


function printForm()
{ ?>
	<!DOCTYPE html>
	<html>

	<head>
		<link rel="stylesheet" href="./Styles/styles.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Mendoza Corporation</title>
		<script src="./Scripts/jquery.min.js"></script>
	</head>

	<body>
		<header>
			<nav class="navbar">
				<div class="logo">
					<img src="./Img/Mendozaco.png"> 
					Mendoza´s Pizza
				</div>
				
				<ul class="nav-links">
					<div class="menu">
						<li><a href="#">Pizzas</a></li>
						<li><a href="#">Combos</a></li>
						<li><a href="#">Extras</a></li>
						<li><a href="#">My order</a></li>
						<li><a href="#">Login</a></li>
					</div>
				</ul>
 			</nav>
		</header>
		<main>
			<div class="container">
				<div class="inputs">
					<div class="brand-logo">
						<img src="./Img/pizza1.png">
					</div>
					<label for="topping">What topping would you like?</label>
					<div>
						<input type="text"  name="topping" id="topping" value="" >
						<div>
							<button type="button" onclick="addTopping()">Add it!</button>
						</div>
						<div>
							<button>Add to cart</button>
						</div>
					</div>
				</div>
				<div>
					<ul id="listToppings"></ul>
				</div>
			</div>
		</main>
		<footer>
        	<div class="footer-content">
				<p>All rights reserved © 2022 | Mendoza Corporation</p>
			</div>
    	</footer>

		<script src="./Scripts/index.js"></script>
	</body>

	</html>
<?php
}
?>