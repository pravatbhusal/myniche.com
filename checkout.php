<html lang="en">
<body>
	<header>
		<title>Checkout</title>   
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
						</ul>
				</div>
			</nav>
		</div>
		
		<!--mobile sidenav-->
		<ul class="side-nav" id="mobile-demo">
			<li><a href="#search-modal" class="modal-trigger"><i class="material-icons">search</i>Search Niche</a></li>
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
		<div class="container" id="itemContainer">
		<ul class="collection">
		<?php 
			include_once("db/dbconnection.php");
			$containsItems = false;
			$i = 0;
			$totalPrice = 0;
			foreach ($_COOKIE as $item=>$quantity) {
				//check if the cookie is one of the niche items
				if(strpos($item, 'anime_') !== false || strpos($item, 'books_') !== false || strpos($item, 'school_') !== false || strpos($item, 'sports_') !== false || strpos($item, 'media_') !== false || strpos($item, 'toys_') !== false || strpos($item, 'games_') !== false || strpos($item, 'deals_') !== false) {
					$itemArray = explode("_", $item); //0 = niche, 1 = item id number
					$query = "SELECT * FROM " . $itemArray[0] . " WHERE id = " . $itemArray[1];
					$result = mysqli_query($link, $query);
					
					$row = mysqli_fetch_array($result);
					$itemId = $itemArray[1];
					$itemName = $row['Item_Name'];
					$Price = $row['Price'];
					$itemIcon = $row['icon'];
						echo '
						<li id="item_'.$i.'" data-itemName='.$item.' data-itemQuantity='.$quantity.' data-itemPrice='.$Price.' class="collection-item avatar" style="margin-top: 10px">
						<div class="row">
							<div class="col s12 m3">
							  <i><img class="materialboxed" src="'.$itemIcon.'" style="width: 150px; height: 150px; border-radius: 25px;"></i>
							</div>
							<div class="col s12 m9">
							  <p><b>'.$itemName.'</b><span style="color: purple"> x '.$quantity.'</span></p>
							  <p style="color: green;">$'.$Price.' USD</p>
							  <p><a onclick="removeCart('.$i.')" class="waves-effect waves-light btn" style="background: #d32f2f;">Remove</a></p>
							</div>
						</div>
						</li>'; 
					$containsItems = true;
					$totalPrice += $Price * $quantity;
					$i++;
				}
			}
		?>
		</ul>
		<?php 
			if($containsItems == false) {
				echo '<h5>Your cart is empty!</h5>';	
			} else {
				echo '
				<button id="paypalBTN" style="float: left;" class="btn waves-effect waves-light" type="submit" name="action">PayPal
					<i class="material-icons right">arrow_forward</i>
				</button>
				<h4 style="color: green; display: inline; margin-left: 10px;" id="totalPrice" data-totalPrice="'.$totalPrice.'">Total: $'.$totalPrice.' USD</h4>
				';
			}
		?>
	</div>
	</main>
	
	<footer class="page-footer" id="footer-page" style="margin-top: 25px;">
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
		
		//deletes a cookie based on the name
		function delete_cookie( name ) {
			document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
		}
			
		function removeCart(itemNumber) {
			var item = document.getElementById("item_" + itemNumber);
			var paypalButton = document.getElementById("paypalBTN");
			var itemName = item.getAttribute("data-itemName");
			var itemQuantity = item.getAttribute("data-itemQuantity");
			var itemPrice = item.getAttribute("data-itemPrice");
			delete_cookie(itemName);
			item.parentNode.removeChild(item); //remove the item
			
			//update the total price
			var totalPriceText = document.getElementById("totalPrice");
			var totalPrice = totalPriceText.getAttribute("data-totalPrice");
			totalPrice -= itemPrice * itemQuantity;
			document.getElementById("totalPrice").innerHTML = "Total: $" + totalPrice + " USD";
			document.getElementById("totalPrice").setAttribute("data-totalPrice", totalPrice);
			
			//if cookies are empty, then notify the user
			if(document.cookie == "") {
				var container = document.getElementById("itemContainer");
				var emptyParagraph = document.createElement("p");
				var node = document.createTextNode("No items in the checkout...");
				emptyParagraph.appendChild(node);
				container.appendChild(emptyParagraph);
				paypalButton.parentNode.removeChild(paypalButton); //remove the paypal button
				totalPriceText.parentNode.removeChild(totalPriceText); //remove the total price text
			}
		}
	</script>
</html>