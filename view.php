<?php

ini_set("display_errors", "On");
error_reporting(E_ALL);

date_default_timezone_set('Europe/Athens');

include("config.php");
$mysqli = new mysqli("localhost", $username, $password, $database);

if ($mysqli === false){
  die("ERROR: Could not connect. " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["op"] == "delete") {
    if ($_POST["passcode"] != $passcode) {
      $alert_type = "danger";
      $alert = "WRONG PASSCODE";
    } else {
      $mysqli->query("DELETE FROM data");
      header("Location: view.php");
      exit();
    }
  }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Panos Bogris, Antony Chazapis">
    <link rel="icon" href="data:,">

    <title>PANHELLENIC 4X4 RESCUE TEAM SARLOC</title>

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12 mb-4">
<?php

if (isset($alert)) {
  echo '<div class="alert alert-'.$alert_type.' alert-dismissible fade show" role="alert">
          '.$alert.'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
}

$result = $mysqli->query("SELECT COUNT(*) AS total FROM data");
if ($result) {
  $row = $result->fetch_assoc();
  $total = $row["total"];
} else {
  $total = "-";
}

$result = $mysqli->query("SELECT args, UNIX_TIMESTAMP(timestamp) AS tstamp, latitude, longitude, notes FROM data ORDER BY timestamp DESC LIMIT 100");
if ($result) {
  if ($result->num_rows == 0) {
    echo '<h4 class="text-center">NO ENTRIES</h4>';
  } else {
    echo '<table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">DATE</th>
                <th scope="col">TIME</th>
                <th scope="col">LAT</th>
                <th scope="col">LONG</th>
                <th scope="col">LINK</th>
                <th scope="col">NOTES</th>
              </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
      echo '<tr>
              <th scope="row">'.strip_tags($row["args"]).'</th>
              <td>'.date("d/n/y", $row["tstamp"]).'</td>
              <td>'.date("H:i:s", $row["tstamp"]).'</td>
              <td>'.($row["latitude"] != 0 ? $row["latitude"] : '').'</td>
              <td>'.($row["longitude"] != 0 ? $row["longitude"] : '').'</td>
              <td>'.(($row["latitude"] != 0 && $row["longitude"] != 0) ? '<a class="text-secondary" href="https://www.google.com/maps/search/?api=1&query='.$row["latitude"].','.$row["longitude"].'" target="_blank">MAP</a>' : '').'</td>
              <td>'.strip_tags($row["notes"]).'</td>
            </tr>';
    }
    echo '</tbody>
        </table>
        <button id="delete-all" type="button" class="btn btn-dark btn-md" data-toggle="modal" data-target="#deleteModal">DELETE ALL ('.$total.')</button>';
  }
}

mysqli_close($mysqli);

?>
        </div>
      </div>
      <footer class="text-muted text-center text-small">
        <p class="mb-1">LINK: <span id="link-text">https://sota.gr/sarloc/locate.php</span> <button id="copy-link-text" type="button" class="btn btn-dark btn-sm">COPY</button></p>
        <p class="mb-1 py-2">PANHELLENIC 4X4 RESCUE TEAM SARLOC<br>Based on <a class="text-secondary" href="https://sarloc.russ-hore.co.uk/" target="_blank">an idea by Russell Hore</a> - <a class="text-secondary" href="https://github.com/chazapis/PRT4x4-SARLOC" target="_blank">Source</a></p>
      </footer>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">DELETE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="passcode">PASSCODE:</label>
                <input type="password" class="form-control" name="passcode">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
              <button type="submit" class="btn btn-primary btn-dark" name="op" value="delete">DELETE</button>
            </div>
          </form>
        </div>
      </div>
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
