<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Panos Bogris, Antony Chazapis">
    <link rel="icon" href="data:,">
    <title>ΠΟΒ4Χ4 SARLOC</title>
  </head>
  <body onload="getLocation()">
    <h2 id="location-text">ΑΝΑΖΗΤΗΣΗ ΣΥΝΤΕΤΑΓΜΕΝΩΝ...</h2>
    <script>
var x = document.getElementById("location-text");
<?php
  $args = isset($_GET["id"]) ? $_GET["id"] : $_SERVER['QUERY_STRING'];
  echo 'var args = "'.$args.'";';
?>

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    x.innerHTML = "Η ΠΡΟΣΒΑΣΗ ΣΤΗΝ ΤΟΠΟΘΕΣΙΑ ΔΕΝ ΥΠΟΣΤΗΡΙΖΕΤΑΙ ΑΠΟ ΑΥΤΟ ΤΟ ΠΡΟΓΡΑΜΜΑ";
  }
}

function showPosition(position) {
  // Send without jQuery.
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process.php", true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send(JSON.stringify({
    "args": args,
    "latitude": position.coords.latitude,
    "longitude": position.coords.longitude
  }));

  x.innerHTML = "Γ. ΜΗΚΟΣ: " + position.coords.latitude + "<br>" +
                "Γ. ΠΛΑΤΟΣ: " + position.coords.longitude + "<br><br>" +
                "Η ΤΟΠΟΘΕΣΙΑ ΕΣΤΑΛΗ<br><br>" +
                "<a href=\"https://www.google.com/maps/search/?api=1&query=" + position.coords.latitude + "," + position.coords.longitude + "\" target=\"_blank\">ΠΡΟΒΟΛΗ ΣΤΟΝ ΧΑΡΤΗ</a>";
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "ΔΕΝ ΕΠΙΤΡΕΠΕΤΑΙ Η ΠΡΟΣΒΑΣΗ ΣΤΗΝ ΤΟΠΟΘΕΣΙΑ"
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML = "ΔΕΝ ΥΠΑΡΧΕΙ ΠΛΗΡΟΦΟΡΙΑ ΤΟΠΟΘΕΣΙΑΣ"
      break;
    case error.TIMEOUT:
      x.innerHTML = "ΠΕΡΑΣΕ Ο ΜΕΓΙΣΤΟΣ ΧΡΟΝΟΣ ΑΝΑΜΟΝΗΣ"
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML = "ΑΓΝΩΣΤΟ ΣΦΑΛΜΑ"
      break;
  }

  // Send without jQuery.
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    console.log('LOG: ' + this.responseText);
  };
  xhr.open("POST", "process.php", true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send(JSON.stringify({
    "args": args,
    "latitude": 0,
    "longitude": 0,
    "notes": x.innerHTML
  }));
}
    </script>
  </body>
</html>
