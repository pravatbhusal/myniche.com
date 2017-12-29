<html lang="en">
<body>
	<header>
		<title>Sport Niches</title>   
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
			<li><a href="#"><i class="material-icons">shopping_cart</i>Checkout</a></li>
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
		$niche = array();
		if(isset($_GET['page'])) {
			if($_GET['page'] > 0) {
				$pageIndex = $_GET['page'] - 1;
			} else {
				$pageIndex = 0;	
			}
		} else {
			$pageIndex = 0;
		}
		
		$viewItems = ($pageIndex * 15) . "," . ($pageIndex + 15); //get 15 items from the current page
		$query = "SELECT * FROM sports ORDER by id DESC LIMIT " . $viewItems;
		$result = mysqli_query($link, $query);
		//iterate through the niche
		while($row = mysqli_fetch_array($result)) {
			$niche[] = $row;
		}
		
		for($i = 0; $i < count($niche); $i++) {
			$itemId = $niche[$i]['id'];
			$itemName = $niche[$i]['Item_Name'];
			$Price = $niche[$i]['Price'];
			$itemDescription = $niche[$i]['Item_Description'];
			$itemIcon = $niche[$i]['icon'];
				echo '
				<li class="collection-item avatar" style="margin-top: 10px">
				<div class="row">
					<div class="col s12 m3">
					  <i><img class="materialboxed" src="'.$itemIcon.'" style="width: 150px; height: 150px; border-radius: 25px;"></i>
					</div>
					<div class="col s12 m9">
					  <p><b>'.$itemName.'</b></p>
					  <p style="color: green;">$'.$Price.' USD</p>
					  Quantity: <input id="quantityText'.$itemId.'" style="width: 50px; height: 25px;" value="1" placeholder="1" type="number" min="1" onkeypress="return event.charCode > 48">
					  <p><a onclick="addCart('.$itemId.')" class="waves-effect waves-light btn" style="background: #323232;">Add to Cart</a></p>
					  <p style="margin-top: 10px">'.$itemDescription.'</p>
					</div>
				</div>
				</li>'; 
		}
		?>	
		</ul>
		<?php 
			if(count($niche) <= 0) {
				echo '<h5>No results found...</h5>';	
			}
		?>
		<ul class="pagination" align="center">
			<li id="previousPage"><a id="previousPageHref" href="?page=<?php echo($pageIndex)?>"><i class="material-icons">chevron_left</i></a></li>
			<li id="currentPage" value="<?php echo($pageIndex +1)?>"><?php echo($pageIndex +1)?></li>
			<li id="nextPage" class="waves-effect"><a href="?page=<?php echo($pageIndex +2)?>"><i class="material-icons">chevron_right</i></a></li>
		</ul>
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
			var cookies = document.cookie.split(';');
			if(cookies == "") {
				numberOfCartItems = 0;
			} else {
				numberOfCartItems = cookies.length;
			}
			//set the number of items in the cart
			document.getElementById('cart-number').innerHTML = numberOfCartItems;
		}
		
		updateNumberOfCartItems();
			
		//addCart function to add items into the cart
		function addCart(itemId) {
			//get the quantity of the item wanting to be purchased
			var quantity = document.getElementById("quantityText" + itemId).value;
			//get the niche name from the URL
			var niche = (window.location.pathname.substring(window.location.pathname.lastIndexOf('/')+1)).replace(".php", "");
			document.cookie = niche + "_" + itemId + "=" + quantity;
			Materialize.toast("Added item into your cart!", 4000);
			updateNumberOfCartItems();
		}
		
		//if we're on the first page or less, then add certain classes for the previous button
		if(document.getElementById("currentPage").value <= 1) {
			document.getElementById("previousPage").className += "disabled";
			document.getElementById("previousPageHref").removeAttribute("href");
		} else {
			document.getElementById("previousPage").className += "waves-effect";
		}
	</script>
</html>