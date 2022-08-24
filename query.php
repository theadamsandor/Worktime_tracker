<?php 

function sectotime($seconds) {
  $t = round($seconds);
  return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}
$date = date('Y-m-d');
print('<!-- header area -->

<div class="row">
  <div style="text-align: center;">
    <h1>Lekérdezések</h1>
  </div>
</div>
  
<!-- actions -->
  <div class="row" style="text-align: center;">
      <form method="POST" action="?page=query">
      <input class="naptar" type="date" id="start" name="trip-start" value="'.$date.'" min="2022-01-01" max="2022-06-01">
      <select name="valaszto" id="valaszto" class="lenyilo">
      ');
          if($_SESSION[rights]=="1")
          { 
            $Mysql_Select = "SELECT * FROM bejelentkezes ORDER BY Nev ASC";
            mysqli_set_charset( $SqlConnection, 'utf8' );
            $sql = $Mysql_Select; $result = $SqlConnection->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                print('<option value="'.$row["id"].'" name="'.$row["id"].'">'.$row["Nev"].'</option>');
              }
              } 
          }
          else{
            print('<option value="'.$_SESSION[userid].'" name="'.$_SESSION[userid].'">'.$_SESSION[displayname].'</option>');
          }
          
      print('
      </select>
      
      <button type="submit" class="tracker_button" >Lekérdez</button>
      <button class="tracker_button">Export CSV</button>
      </form>
      
       
  </div>


<!-- table -->
  <table id="timeTable" class="table">
      <tr class="table_row">
        <th>Művelet</th>
        <th>Idő</th>
     </tr> 
     ');
     if (isset($_POST["valaszto"])) {$id = $_POST["valaszto"];} else {$id = 0;}
     if (isset($_POST["trip-start"])) {$date = $_POST["trip-start"];}
     $breaksum = 0;
     $worksum = 0;
     $Mysql_Select = "SELECT * FROM jelenleti WHERE id = '$id' && datum>='$date' ORDER BY datum ASC";
          mysqli_set_charset( $SqlConnection, 'utf8' );
          $sql = $Mysql_Select; $result = $SqlConnection->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

              switch ($row["bejegyzes_jellege"]) {
                case "addlogIn":
                    $row["bejegyzes_jellege"] = "Bejelentkezés";
                    $worksum = $worksum - strtotime($row["datum"]);
                    break;
                case "addbreak":
                    $row["bejegyzes_jellege"] = "Szünet kezdete";
                    $breaksum = $breaksum - strtotime($row["datum"]);
                    break;
                case "addbreakEnd":
                    $row["bejegyzes_jellege"] = "Szünet vége";
                    $breaksum = $breaksum + strtotime($row["datum"]);
                    break;
                case "addlogOut":
                    $row["bejegyzes_jellege"] = "Kijelentkezés";
                    $worksum = $worksum + strtotime($row["datum"]);
                    break;
              }

              print('
              <tr class="table_row">
                <td>'.$row["bejegyzes_jellege"].'</td>
                <td>'.$row["datum"].'</td>
              </tr>');
            }
            } 
     print('
  </table>

  <table id="timeTable" class="table">
      <tr class="table_row">
        <th>Ledolgozott idő: '.sectotime($worksum).'</th>
     </tr> 
   </table>
   
   <table id="timeTable" class="table">
      <tr class="table_row">
        <th>Összes szünet: '.sectotime($breaksum).'</th>
     </tr> 
   </table>
');
?>