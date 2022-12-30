<?php
require_once 'connect.php';
session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <title>Account Management</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">MegaPay Solutions</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">

      </ul>

    </div>
  </nav>

  <div class="h1 text-center">Accounting Management System</div>
  <div class="container d-flex justify-content-center justify-content-center" style="padding-top: 230px;padding-left: 188px;">
    <form action="user_dashboard.php" method="POST" class="w-100">

      <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <?php echo $_SESSION['message']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

      <?php session_unset();
      } ?>
      <div class="row">
        <div class="col">
          <select name="selected_user" class="custom-select" id="">
            <?php
            $query = $conn->query("SELECT * FROM accounts");
            $items =  $query->fetchAll();
            foreach ($items as $item) { ?>
              <option class="dropdown-item" value="<?php echo $item['user_id']; ?>"><?php echo $item['user_id']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col">
        <input type="submit" value="Go" class="btn btn-primary" name="user_sel">
        </div>
      </div>
    </form>
  </div>
</body>

</html>