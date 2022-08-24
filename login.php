<?php
$loginerror = "";
if (isset($_GET["error"]) && $_GET["error"] == 1) {$loginerror='<div class="login-error">Hibás felhasználónév vagy jelszó!</div>';}

print('<h1 align="center">Munkaidő nyilvántartó rendszer</h1>
'.$loginerror.'
<div class="login-page">
  <div class="form">
    <form method="POST" action="?page=login&action=check">
      <input type="text" name="username" placeholder="Felhasználónév"/>
      <input type="password" name="password" placeholder="Jelszó"/>
      <button>Bejelentkezés</button>
    </form>
  </div>
</div>');

if(isset($_GET["action"]) && $_GET["action"] == 'check') {

$username = stripslashes($_REQUEST['username']);
$username = mysqli_real_escape_string($SqlConnection,$username);
$password = stripslashes($_REQUEST['password']);
$password = mysqli_real_escape_string($SqlConnection,$password);
$password = md5($password);
//CHECKING

$query = "SELECT * FROM bejelentkezes WHERE felhasznalonev = '$username' AND jelszo = '$password'";
$result = mysqli_query($SqlConnection,$query) or die(mysql_error());
$rows = mysqli_num_rows($result);
  if($rows==1){

    $mysqli = new mysqli(SQL_HOST, SQL_USERNAME, SQL_PASSWORD, DB_NAME);
    if ($mysqli->connect_error) { die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);}
    mysqli_set_charset($mysqli, 'utf8' );

    //LOGIN
    $_SESSION["displayname"] = $mysqli->query("SELECT Nev FROM bejelentkezes WHERE felhasznalonev = '$username'")->fetch_object()->Nev;
    $_SESSION["userid"] = $mysqli->query("SELECT id FROM bejelentkezes WHERE felhasznalonev = '$username'")->fetch_object()->id;
    $_SESSION["rights"] = $mysqli->query("SELECT Jogosultsag FROM bejelentkezes WHERE felhasznalonev = '$username'")->fetch_object()->Jogosultsag;
    $_SESSION["username"] = "loginuser";
    $_SESSION["loggedin"] = true;

    //REDIRECT
    header('Location: ?page=main');
    exit;
  } else {
 
    header('Location: index.php?page=login&error=1');
    exit;

  }
}
?>