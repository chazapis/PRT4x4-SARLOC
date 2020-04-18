<!doctype html>
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$username = "root";
$password = "root";
$database = "sarloc";
$mysqli = new mysqli("localhost", $username, $password, $database);

if ($mysqli === false){
  die("ERROR: Could not connect. " . $mysqli->connect_error);
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Antony Chazapis">
    <link rel="icon" href="data:,">

    <title>ΠΑΝΕΛΛΑΔΙΚΗ ΟΜΑΔΑ ΒΟΗΘΕΙΑΣ 4Χ4 SARLOC</title>

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="images/logo-omada.gif" alt="" width="138" height="119">
        <h2>Κλήσεις SAR</h2>
        <p class="lead">Στείλτε με μήνυμα τη διεύθυνση <span id="link-text">https://sota.gr/sarloc/locate.php</span>. <button id="copy-link-text" type="button" class="btn btn-dark btn-sm">Αντιγραφή</button><br>Η σελίδα αυτή θα εντοπίσει τη θέση του παραλήπτη και θα εμφανίσει τα στοιχεία εδώ.</p>
      </div>
      <div class="row">
        <div class="col-12 mb-4">
<?php

$result = $mysqli->query("select * from location order by timestamp");
if ($result) {
  if ($result->num_rows == 0) {
    echo '<h4 class="text-center">Δεν υπάρχουν κλήσεις.</h4>';
  } else {
    echo '<table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Ώρα (UTC)</th>
                <th scope="col">Γεωγρ. Πλάτος</th>
                <th scope="col">Γεωγρ. Μήκος</th>
                <th scope="col">Σημειώσεις</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
      echo '<tr>
              <th scope="row">'.$row["id"].'</th>
              <td>'.$row["timestamp"].'</td>
              <td>'.$row["latitude"].'</td>
              <td>'.$row["longitude"].'</td>
              <td>'.$row["notes"].'</td>
              <td><a class="text-secondary" href="https://www.google.com/maps/search/?api=1&query='.$row["latitude"].','.$row["longitude"].'" target="_blank">Χάρτης</a></td>
            </tr>';
    }
    echo '</tbody>
        </table>
        <button id="delete-all" type="button" class="btn btn-dark btn-sm">Διαγραφή όλων</button>';
  }
}

?>
        </div>
      </div>
      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">ΠΑΝΕΛΛΑΔΙΚΗ ΟΜΑΔΑ ΒΟΗΘΕΙΑΣ 4Χ4 SARLOC<br>Βασισμένο σε <a class="text-secondary" href="https://sarloc.russ-hore.co.uk/" target="_blank">μια ιδέα του Russell Hore</a> - <a class="text-secondary" href="https://github.com/chazapis/sarloc" target="_blank">Κώδικας σελίδας</a></p>
      </footer>
    </div>

    <!-- jQuery first, then Bootstrap JS with Popper.js -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
$(function (){
    $("#copy-link-text").click(function () {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($("#link-text").text()).select();
        document.execCommand("copy");
        $temp.remove();
    });

    $("#delete-all").click(function () {
        console.log("DELETE ALL");
    });
});
    </script>
  </body>
</html>

