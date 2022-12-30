
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
        <div class="nav-item">

        </div>
      </ul>
    </div>
  </nav>

<?php
include 'connect.php';
session_start();
if(isset($_POST['buy'])){
    $id= $_POST['buy'];
    $fetch_query="SELECT * FROM products INNER JOIN charge_slabs ON products.charge_slab_id=charge_slabs.id where product_id= $id";
    $run_fetch_query=$conn->query($fetch_query);
    $result=$run_fetch_query->fetchAll();
    // echo "<pre>"; print_r($result);echo "<pre>";
    
        foreach($result as $value){
            $product_type=$value['product_name'];
            $product_cost=$value['product_cost'];
            $charges_type=$value['charges_type'];
            
        // converting the % amount into a numeric value 
            if($charges_type=='PERCENT'){
                $charge_value=($product_cost*$value['charge_value'])/100;
            }else{
                $charge_value=$value['charge_value']; 
            }
            $disc_type=$value['disc_type'];
            
        // converting the % amount into a numeric value 
            if($disc_type =='PERCENT'){
                $disc_value=($product_cost*$value['disc_value'])/100;
            }else{
                $disc_value=$value['disc_value']; 
            }   
            $disc_value;
            $max_charge=$value['max_charge_value'];
            $max_disc=$value['max_disc_value'];
        }
    
    if($_SESSION['current_balance']>=$product_cost){
      
    // total debit amount from user account
    $debit_value=$product_cost + $charge_value;

    //discount will come after the transaction
    $credit_value=$disc_value;

    //balance after the transaction 
    $available_amount=$_SESSION['current_balance']-$debit_value + $disc_value;

    // comission value and charge values will be same because of no extra charges 
    $commission=$charge_value;


    // code for unique transaction_id
    function gen_uuid($len = 12)
    {
        $hex = md5("your_random_salt_here_31415" . uniqid("", true));
        $pack = pack('H*', $hex);
        $uid = base64_encode($pack);        // max 22 chars
        $uid = preg_replace("[^A-Za-z0-9]", "", $uid);    // mixed case
        //$uid = ereg_replace("[^A-Z0-9]", "", strtoupper($uid));    // uppercase only
    
        if ($len < 4)
            $len = 4;
        if ($len > 128)
            $len = 128;                       // prevent silliness, can remove
    
        while (strlen($uid) < $len)
            $uid = $uid . gen_uuid(22);     // append until length achieved
        //replace + with random (0,9)
        if(strstr($uid,'+')){
            $rand = rand(0,9);
            $uid = str_replace("+",$rand,$uid);
        }
        return substr($uid, 0, $len);
    }
        $account_id= $_SESSION['account_id'];
        $txn_id = gen_uuid(12);
        $date = date('Y-m-d H:i:s');

        //transaction Query
        $query = $conn->query("INSERT into transactions (created_on,transaction_id,account_id,product_type,debit,credit,charges,commission,balance_after_transaction) VALUES('$date','$txn_id','$account_id','$product_type','$debit_value','$credit_value','$charge_value','$commission','$available_amount')");
        $items =  $query->fetchAll();

        $update_query=$conn->query("UPDATE accounts SET current_balance= $available_amount WHERE account_id=$account_id");
        echo '<div class="alert alert-success" role="alert">Transaction completed successfully<br></div>';?>
        <a href="exit.php" class="btn btn-danger btn-lg" style="margin-left: 50vw;">Exit</a>
    <?php
    }else{
        echo '<div class="alert alert-danger" role="alert">Oops!! You have enough money for transaction<br></div>';
        ?>
        
        <a href="exit.php" class="btn btn-danger btn-lg" style="margin-left: 50vw;">Exit</a>
        <?php
        // $_SESSION['message']="You have not enough amount!!!";
        // header('location: index.php');
        // exit();
    }            
}else{
    header('location: index.php');
    die();
}
?>

</body>
</html>