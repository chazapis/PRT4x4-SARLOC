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
          <form method="post" action="process.php">
            <div class="form-group row">
              <label for="inputId" class="col-sm-2 col-form-label">ID</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputId" name="args">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputLat" class="col-sm-2 col-form-label">LAT</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputLat" name="latitude">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputLong" class="col-sm-2 col-form-label">LONG</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputLong" name="longitude">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputNotes" class="col-sm-2 col-form-label">NOTES</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputNotes" name="notes">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-dark btn-md">SUBMIT</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <footer class="text-muted text-center text-small">
        <p class="mb-1">LINK: <span id="link-text">https://sota.gr/sarloc/locate.php</span> <button id="copy-link-text" type="button" class="btn btn-dark btn-sm">COPY</button></p>
        <p class="mb-1 py-2">PANHELLENIC 4X4 RESCUE TEAM SARLOC<br>Based on <a class="text-secondary" href="https://sarloc.russ-hore.co.uk/" target="_blank">an idea by Russell Hore</a> - <a class="text-secondary" href="https://github.com/chazapis/PRT4x4-SARLOC" target="_blank">Source</a></p>
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
});
    </script>
  </body>
</html>
