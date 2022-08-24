<?php
print('
<!-- header area -->

  <div class="row">
    <div style="text-align: center;">
      <h1>Munkaidő nyilvántartás</h1>
    </div>
  </div>
    
<!-- buttons -->
  <div class="row">
    <div id="buttons" style="text-align: center;">
      <a href="index.php?page=main&action=addlogIn"><button class="tracker_button" type="button">Munka elkezdése</button></a>
      <a href="index.php?page=main&action=addbreak"><button class="tracker_button">Szünet</button></a>
	    <a href="index.php?page=main&action=addbreakEnd"><button class="tracker_button">Szünet vége</button></a>
      <a href="index.php?page=main&action=addlogOut"><button class="tracker_button">Munka befejezése</button></a>
      
    </div>
  </div>
  
<!-- table -->
      <table id="timeTable" class="table">
        <tr class="table_row">
          <th>Művelet</th>
          <th>Idő</th>
        </tr>');
          $limitdate = date('Y-m-d');
          $id = $_SESSION["userid"];
          $Mysql_Select = "SELECT * FROM jelenleti WHERE datum>'$limitdate' && id='$id' ORDER BY record ASC";

          mysqli_set_charset( $SqlConnection, 'utf8' );
          $sql = $Mysql_Select; $result = $SqlConnection->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              
              switch ($row["bejegyzes_jellege"]) {
                case "addlogIn":
                    $row["bejegyzes_jellege"] = "Bejelentkezés";
                    break;
                case "addbreak":
                    $row["bejegyzes_jellege"] = "Szünet kezdete";
                    break;
                case "addbreakEnd":
                    $row["bejegyzes_jellege"] = "Szünet vége";
                    break;
                case "addlogOut":
                    $row["bejegyzes_jellege"] = "Kijelentkezés";
                    break;
            }

              print('
              <tr>
              <td>'.$row["bejegyzes_jellege"].'</td><td>'.$row["datum"].'</td>
              </tr>');
            }
            } 
          else {echo "<tr><td>Mára nincs megjeleníthető bejegyzés</td><td></td><tr>";}

          print('</table>');

if (isset($_GET["action"])) {

  $datum = date("Y-m-d h-i-sa");
  $id = $_SESSION["userid"];
  $action = $_GET["action"];

    mysqli_set_charset( $SqlConnection, 'utf8' );
    $sql = "INSERT INTO jelenleti (id, datum, bejegyzes_jellege) VALUES ('$id', '$datum', '$action')";
    if ($SqlConnection->query($sql) === TRUE) {header('location: index.php?page=main');} else {echo "Error: " . $sql . "<br>" . $SqlConnection->error;}
    break;
}
?>