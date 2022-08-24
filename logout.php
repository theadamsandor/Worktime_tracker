<?php
unset($_SESSION["username"]);
unset($_SESSION["loggedin"]);
unset($_SESSION["displayname"]);
unset($_SESSION["userid"]);

echo 'Sikeresen kijelentkeztés! Hamarosan tovább irányítunk!';
header('Refresh: 2; URL = index.php?page=login');
?>