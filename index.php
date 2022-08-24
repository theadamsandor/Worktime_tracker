<?php
//DEF INC.
require('config.php');
require('functions.php');

//LOGIN REDIRECT
if($_GET["page"] != "login" && (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)){
    header("location: index.php?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="hu"> 
	<head>
		<meta charset="UTF-8"> 
		<title> Munkaidő nyilvántartás</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="formaz.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">

		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

		<script>
		$( function() {
		$( "#datepicker" ).datepicker();
		} );
		</script>

	</head>
<body>

<div>
<?php 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    print('
		Üdv '.$_SESSION["displayname"].'! 
		<a href="index.php?page=logout"><button class="tracker_button">Kijelentkezés</button></a>
		<a href="index.php?page=query"><button class="tracker_button">Lekérdezés</button></a>
		<a href="index.php?page=main"><button class="tracker_button">Munkaidő nyilvántartás</button></a>
	');
}
?>
</div>


<?php
//CONTENT
if(isset($_GET["page"])) {
    include($_GET["page"].".php");
}
else {
    include('main.php');
}
?>

</body>
</html>