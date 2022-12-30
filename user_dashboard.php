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
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <?php
        if(isset($_REQUEST['selected_user'])){
            $user_id = $_REQUEST['selected_user'];
            $query = $conn->query("SELECT * FROM accounts WHERE user_id = $user_id");
            $items =  $query->fetchAll();
            foreach($items as $item){
                $_SESSION['account_id'] = $item['account_id'];
                $_SESSION['current_balance'] = $item['current_balance'];
            }?>
            <li class="nav-item bg-light">
              <span>BALANCE:</span><?php echo $_SESSION['current_balance']; ?>
              </li> 
              </ul>
              <?php
            }else{
                header('Location: index.php');
            }?>  
    
  </div>
</nav>

    <div class="container d-flex justify-content-center justify-content-center">

    </div>
    <div class="container">
      <h2 class="text-center">Product List</h2>
      <?php
        $product_query="SELECT * FROM products";
        $run_query=$conn->query($product_query);
        $result=$run_query->fetchAll();
        // echo"<pre>";print_r($result);
        ?>
        <table class="table">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Product Cost</th>
              <th>Buy Product</th>
            </tr>
          </thead>
        <?php
        foreach($result as $data)
        { ?>
          <tbody>
            <tr>
              <td scope="row"><?php echo $data['product_name'];?></td>
              <td><?php echo $data['product_cost'];?></td>
              <td><form method="post" action="txn.php">
                <button type="submit" name="buy" value="<?php echo $data['charge_slab_id'];?>" class="btn btn-sm btn-primary">Buy</button>
              </form></td>
            </tr>
          </tbody>
          <?php  
        }  ?>
      </table>

      <h2 class="text-center">Transaction List</h2>

      <table class="table">
        <thead>
          <tr>
            <th>s.no</th>
            <th>Transaction Date</th>
            <th>Transaction Id</th> 
          </tr>
        </thead>
      <?php
            $query = $conn->query("SELECT * FROM transactions");
            $items =  $query->fetchAll();
            foreach ($items as $item) { ?>
          <tbody>
            <tr>
              <td scope="row"><?php echo $item['id'];?></td>
              <td><?php echo $item['created_on'];?></td>
              <td><?php echo $item['transaction_id'];?></td>
            </tr>
          </tbody>
          <?php  
        }  ?>
      </table>
    </div>
  </body>
</html>

