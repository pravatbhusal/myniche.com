<html lang="en">
<body>
	<header>
		<title>Search</title>   
		<!--style.css, favcon, googlefont, materializecss-->
		<link href="styles/nichestyle.css" type="text/css" rel="stylesheet">       
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">  	
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
		
		<meta charset="utf-8"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<meta name="description" content=""> 
		<meta name="author" content=""> 
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/> 

	  <!--search modal-->
	  <div id="search-modal" class="modal">
		<div class="modal-content">
				<div class="input-field col s6">
					<form action="search.php" method="GET">
						<input placeholder="Search..." name="search" autofocus required type="text">
					</form>
				</div>
		</div>
	  </div>
									
		<!--navbar-->
		<div class="navbar-fixed">
			<nav id="nav-selector">
				<div class="nav-wrapper">
					<a href="index.php" class="brand-logo" id="website-logo"><i class="material-icons">whatshot</i></a>
					<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
						<ul class="right hide-on-med-and-down" id="tab-items">
							<li><a href="anime.php" id="niche-item-tab">Anime</a></li>
							<li><a href="books.php" id="niche-item-tab">Books</a></li>
							<li><a href="school.php" id="niche-item-tab">School</a></li>
							<li><a href="sports.php" id="niche-item-tab">Sports</a></li>
							<li><a href="media.php" id="niche-item-tab">Media</a></li>
							<li><a href="toys.php" id="niche-item-tab">Toys</a></li>
							<li><a href="games.php" id="niche-item-tab">Games</a></li>
							<li><a href="deals.php" id="special-deals-tab">Special Deals</a></li>
							<li><a href="#search-modal" class="modal-trigger"><i class="material-icons">search</i></a></li>
							<li><a href="checkout.php"><i class="material-icons">shopping_cart</i></a></li>
							<li><label id="cart-number">0</label></li>
						</ul>
				</div>
			</nav>
		</div>
		
		<!--mobile sidenav-->
		<ul class="side-nav" id="mobile-demo">
			<li><a href="#search-modal" class="modal-trigger"><i class="material-icons">search</i>Search Niche</a></li>
			<li><a href="checkout.php"><i class="material-icons">shopping_cart</i>Checkout</a></li>
			<li><a href="deals.php" id="niche-item-tab">Special Deals</a></li>
			<li><a href="anime.php" id="niche-item-tab">Anime</a></li>
			<li><a href="books.php" id="niche-item-tab">Books</a></li>
			<li><a href="school.php" id="niche-item-tab">School</a></li>
			<li><a href="sports.php" id="niche-item-tab">Sports</a></li>
			<li><a href="media.php" id="niche-item-tab">Media</a></li>
			<li><a href="toys.php" id="niche-item-tab">Toys</a></li>
			<li><a href="games.php" id="niche-item-tab">Games</a></li>
		</ul>
	</header>
	
	<main>
		<div class="container">
		<ul class="collection">
		<?php	
		include_once("db/dbconnection.php");
		$foundResult = false;
		
		//get queries that contain the search string (MySQL is case-insensitive)
		$search = $_GET['search'];
		$queryAnime = "SELECT * FROM anime WHERE Item_Name LIKE '%" . $search . "%'";
		$queryBooks = "SELECT * FROM books WHERE Item_Name LIKE '%" . $search . "%'";
		$querySchool = "SELECT * FROM school WHERE Item_Name LIKE '%" . $search . "%'";
		$querySports = "SELECT * FROM sports WHERE Item_Name LIKE '%" . $search . "%'";
		$queryMedia = "SELECT * FROM media WHERE Item_Name LIKE '%" . $search . "%'";
		$queryToys = "SELECT * FROM toys WHERE Item_Name LIKE '%" . $search . "%'";
		$queryGames = "SELECT * FROM games WHERE Item_Name LIKE '%" . $search . "%'";
		$queryDeals = "SELECT * FROM deals WHERE Item_Name LIKE '%" . $search . "%'";
		
		$results = array();
		$results[] = mysqli_query($link, $queryAnime);
		$results[] = mysqli_query($link, $queryBooks);
		$results[] = mysqli_query($link, $querySchool);
		$results[] = mysqli_query($link, $querySports);
		$results[] = mysqli_query($link, $queryMedia);
		$results[] = mysqli_query($link, $queryToys);
		$results[] = mysqli_query($link, $queryGames);
		$results[] = mysqli_query($link, $queryDeals);
		
		for($i = 0; $i < 8; $i ++) {
			while($row = mysqli_fetch_array($results[$i])) {	
				$itemId = $row['id'];
				$itemName = $row['Item_Name'];
				$Price = $row['Price'];
				$itemDescription = $row['Item_Description'];
				$itemIcon = $row['icon'];
					echo '
					<li class="collection-item avatar" style="margin-top: 10px">
					<div class="row">
						<div class="col s12 m12 l3">
						  <i><img class="materialboxed" src="'.$itemIcon.'" style="width: 150px; height: 150px; border-radius: 25px;"></i>
						</div>
						<div class="col s12 m12 l9">
						  <p><b>'.$itemName.'</b></p>
						  <p style="color: green;">$'.$Price.' USD</p>
						  Quantity: <input id="quantityText'.$itemId.'" style="width: 50px; height: 25px;" value="1" placeholder="1" type="number" min="1" onkeypress="return event.charCode > 48">
						  <p><a onclick="addCart('.$itemId.', '.$i.')" class="waves-effect waves-light btn" style="background: #323232;">Add to Cart</a></p>
						  <p style="margin-top: 10px">'.$itemDescription.'</p>
						</div>
					</div>
					</li>'; 
				$foundResult = true;
			}
		}
		?>	
		</ul>
		<?php 
			if($foundResult == false) {
				echo '<h5>No results found...</h5>';	
			}
		?>
	</div>
	</main>
	
	<footer class="page-footer" id="footer-page">
		<div class="container">
				<div class="row">
					<div class="col l6 s12">
						<h5 id="footer-header-text">About</h5>
						<p id="footer-sub-text">Niche is a service that allows for users to purchase 
						cheap items for their favorite hobbies, fandoms, and collections.</p>
						</div>
						<div class="col l4 offset-l2 s12">
						<h5 id="footer-header-text">Niches</h5>
						<ul>
						<li><a id="footer-sub-text" href="anime.php">Anime</a></li>
						<li><a id="footer-sub-text" href="books.php">Books</a></li>
						<li><a id="footer-sub-text" href="school.php">School</a></li>
						<li><a id="footer-sub-text" href="sports.php">Sports</a></li>
						<li><a id="footer-sub-text" href="media.php">Media</a></li>
						<li><a id="footer-sub-text" href="toys.php">Toys</a></li>
						<li><a id="footer-sub-text" href="games.php">Games</a></li>
						</ul>
					</div>
				</div>
		</div>
				<div class="footer-copyright" id="footer-trademark">
					<div class="container" id="footer-sub-text">
					Copyright &copy 2018 Niche Inc. All rights reserved.
					</div>
				</div>
	</footer>
	
		<!--jquery, materializejs-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
</body>	
	<script>
		//modal, collapseSideNav settings
		$('.modal').modal();
		$(".button-collapse").sideNav();
		
		//get number of cart items within the browser
		function updateNumberOfCartItems() {
			var numberOfCartItems = 0;
			numberOfCartItems += (document.cookie.split('anime_').length-1);
			numberOfCartItems += (document.cookie.split('books_').length-1);
			numberOfCartItems += (document.cookie.split('school_').length-1);
			numberOfCartItems += (document.cookie.split('sports_').length-1);
			numberOfCartItems += (document.cookie.split('media_').length-1);
			numberOfCartItems += (document.cookie.split('toys_').length-1);
			numberOfCartItems += (document.cookie.split('games_').length-1);
			numberOfCartItems += (document.cookie.split('deals_').length-1);
			//set the number of items in the cart
			document.getElementById('cart-number').innerHTML = numberOfCartItems;
		}
		
		updateNumberOfCartItems();
			
		//addCart function to add items into the cart
		function addCart(itemId, itemTable) {
			var niche = "";
			if(itemTable == 0) {
				niche = "anime";
			} else if(itemTable == 1) {
				niche = "books";
			} else if(itemTable == 2) {
				niche = "school";
			} else if(itemTable == 3) {
				niche = "sports";
			} else if(itemTable == 4) {
				niche = "media";
			} else if(itemTable == 5) {
				niche = "toys";
			} else if(itemTable == 6) {
				niche = "games";
			} else if(itemTable == 7) {
				niche = "deals";
			}
			//get the quantity of the item wanting to be purchased
			var quantity = document.getElementById("quantityText" + itemId).value;
			document.cookie = niche + "_" + itemId + "=" + quantity;
			Materialize.toast("Added item into your cart!", 4000);
			updateNumberOfCartItems();
		}
	</script>
</html>