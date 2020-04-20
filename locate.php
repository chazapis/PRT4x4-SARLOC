<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Panos Bogris, Antony Chazapis">
    <link rel="icon" href="data:,">
    <title>ΠΟΒ4Χ4 SARLOC</title>
    <style>
      body {
        font-family: Arial, Helvetica, sans-serif;
      }
    </style>
  </head>
  <body onload="getLocation()">
    <h2 id="location-text">ΑΝΑΖΗΤΗΣΗ ΣΥΝΤΕΤΑΓΜΕΝΩΝ...</h2>
    <p id="help-text">Περιμένετε 30 δευτερόλεπτα. Αν δεν εμφανιστουν συντεταγμένες καντε refresh τη σελίδα.</p>
    <script>
var x = document.getElementById("location-text");
var h = document.getElementById("help-text");
<?php
  $args = isset($_GET["id"]) ? $_GET["id"] : $_SERVER['QUERY_STRING'];
  $args = substr($args, 0, 5);
  echo 'var args = "'.addslashes($args).'";';
?>

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    x.innerHTML = "Η ΠΡΟΣΒΑΣΗ ΣΤΗΝ ΤΟΠΟΘΕΣΙΑ ΔΕΝ ΥΠΟΣΤΗΡΙΖΕΤΑΙ ΑΠΟ ΑΥΤΟ ΤΟ ΠΡΟΓΡΑΜΜΑ";
    showHelp();
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
  h.innerHTML = "";
}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "ΔΕΝ ΕΠΙΤΡΕΠΕΤΑΙ Η ΠΡΟΣΒΑΣΗ ΣΤΗΝ ΤΟΠΟΘΕΣΙΑ"
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML = "ΔΕΝ ΥΠΑΡΧΕΙ ΠΛΗΡΟΦΟΡΙΑ ΤΟΠΟΘΕΣΙΑΣ"
      break;
    case error.TIMEOUT:
      x.innerHTML = "ΠΕΡΑΣΕ Ο ΜΕΓΙΣΤΟΣ ΧΡΟΝΟΣ ΑΝΑΜΟΝΗΣ"
      break;
    // case error.UNKNOWN_ERROR:
    default:
      x.innerHTML = "ΑΓΝΩΣΤΟ ΣΦΑΛΜΑ"
      break;
  }
  showHelp();

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

function showHelp() {
  if (navigator.userAgent.match(/(iPad|iPhone|iPod)/g)) {
    h.innerHTML = "Αν είστε κάτοχος συσκευής <b>iPhone</b>, παρακαλούμε μεταβείτε στις Ρυθμίσεις στο: Γενικά => Επαναφορά => Τοποθεσία και απόρρητο και κάντε επαναφορά. Στη συνέχεια ξαναπατήστε στο σύνδεσμο που λάβατε με SMS.";
  } else {
    h.innerHTML = "Αν είστε κάτοχος συσκευής <b>Android</b>, παρακαλούμε βεβαιωθείτε ότι χρησιμοποιείτε τον Chrome browser, ότι οι υπηρεσίες τοποθεσίας ειναι ενεργές (Υψηλή ακρίβεια) και ότι στον Chrome επιτρέπεται η διαχείρηση της τοποθεσίας σας (Ρυθμίσεις => Υπηρεσίες Τοποθεσίας). Στη συνέχεια ξαναπατήστε στο σύνδεσμο που λάβατε με SMS.";
  }
}
    </script>
  </body>
</html>
