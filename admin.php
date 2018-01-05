<html lang="en">
<body>
	<header>
		<title>Admin</title>   
		<!--style.css, favcon, googlefont, materializecss-->
		<link href="styles/indexstyle.css" type="text/css" rel="stylesheet">       
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">  	
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
		
		<!--jquery, materializejs-->
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
		
		<meta charset="utf-8"> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<meta name="description" content=""> 
		<meta name="author" content=""> 
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
		
		<!--upload item modal-->
		<div id="upload-item-modal" class="modal">
			<div class="modal-content">
				<div class="row">
					<form action="db/upload.php" method="POST" enctype="multipart/form-data">
					<b><p style="text-align: center;" class="input-field col s12 m12 l12">Upload an Item</p></b>
						<select class="browser-default input-field col s12 m12 l12" name="nicheType">
						  <option value="anime">Anime</option>
						  <option value="books">Books</option>
						  <option value="school">School</option>
						  <option value="sports">Sports</option>
						  <option value="media">Media</option>
						  <option value="toys">Toys</option>
						  <option value="games">Games</option>
						  <option value="deals">Deals</option>
						</select>
						<input required name="itemName" class="input-field col s12 m12 l12" type="text"  placeholder="Item Name" style="width: 600px;"></input>
						<input required name="itemPrice" class="input-field col s12 m12 l12" placeholder="Price in USD" style="width: 200px;" min="1" onkeypress="return isNumberKey(event)"></input>
						<textarea required id="itemDescription" name="itemDescription" style="width: 600px;" placeholder="Item Description" class="materialize-textarea input-field col s12 m12 l12"></textarea>
						<h6 class="input-field col s12 m12 l3">Picture File:</h6>
						<input required type="file" id="itemPicture" name="itemPicture" accept="image/*" class="input-field col s12 m12 l6">
						<button type="submit" class="btn input-field col s12 m12 l12">Upload</button>
					</form>
				</div>
			</div>
		</div>
		
		<!--delete item modal-->
		<div id="delete-item-modal" class="modal">
			<div class="modal-content">
				<div class="row">
					<form action="db/delete.php" method="POST">
					<b><p style="text-align: center;" class="input-field col s12 m12 l12">Delete an Item</p></b>
						<select class="browser-default input-field col s12 m12 l12" name="nicheType">
						  <option value="anime">Anime</option>
						  <option value="books">Books</option>
						  <option value="school">School</option>
						  <option value="sports">Sports</option>
						  <option value="media">Media</option>
						  <option value="toys">Toys</option>
						  <option value="games">Games</option>
						  <option value="deals">Deals</option>
						</select>
						<input required name="itemName" class="input-field col s12 m12 l12" type="text"  placeholder="Item Name" style="width: 500px;"></input>
						<button type="submit" class="btn input-field col s12 m12 l12">Delete</button>
					</form>
				</div>
			</div>
		</div>
		
		<?php
		include_once("db/dbconnection.php");
		
		if(isset($_POST['password'])) {
			$password = $_POST['password'];
		} else {
			$password = "";	
		}
		
		if($password == $adminPassword) {
			echo '<div id="adminDiv" style="text-align: center">
			<b><h4 style="color: #e53935;">Admin Control Panel</h4></b>
			<br>
			<button href="#upload-item-modal" class="modal-trigger btn" style="margin-bottom: 10px;">Upload an item</button>
			<br>
			<button href="#delete-item-modal" class="modal-trigger btn" style="margin-bottom: 10px; background-color: #e53935;">Delete an item</button>
			<br>
			<a href="index.php">Click here to go back to the home page.</a>
			</div>
			';
		} else if($password != "") {
			echo '<form style="text-align: center;" method="POST" action="admin.php">
			<b><h4 style="color: #e53935;">Admin Panel</h4></b>
			<br>
			<p style="color: red; text-align: center;">The password you entered was incorrect!</p>
			<br>
			<input type="password" name="password" align="center" placeholder="Password" style="width: 500px;"></input>
			<br>
			<input type="submit" name="submit" class="btn" value="Submit" style="background-color: #e53935; margin-bottom: 10px;"></input>
			<br>
			<a href="index.php">If you are not an Admin, then it is highly advised that you leave this page.</a>
			</form>';
		} else {
			echo '<form style="text-align: center;" method="POST" action="admin.php">
			<b><h4 style="color: #e53935;">Admin Panel</h4></b>
			<br>
			<input type="password" name="password" align="center" placeholder="Password" style="width: 500px;"></input>
			<br>
			<input type="submit" name="submit" class="btn" value="Submit" style="background-color: #e53935; margin-bottom: 10px;"></input>
			<br>
			<a href="index.php">If you are not an Admin, then it is highly advised that you leave this page.</a>
			</form>';
		}
		?>
	</header>
	
	<main>
		
	</main>
	
	<footer>
	
	</footer>
</body>

	<script>
		//modal, text editor settings
		$('.modal').modal();
		$('#itemDescription').trigger('autoresize');
		
		function isNumberKey(evt)
		{
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 
			&& (charCode < 48 || charCode > 57))
			 return false;

			return true;
		}
	</script>
</html>