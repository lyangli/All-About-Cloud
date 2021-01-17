<?php
error_reporting(0);
//echo $_POST["productID"]."---".$_POST["productName"]."---".$_POST["qty"];  

$servername = $_POST["servername"];
$username = $_POST["username"];
$password = $_POST["password"];
$dbname = "demo";


$mysqli = mysqli_init();
$mysqli->ssl_set(NULL, NULL, '/etc/ssl/mysql/rds-combined-ca-bundle.pem', NULL, 'DHE-RSA-AES256-SHA');
$mysqli->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

if (!mysqli_real_connect ($mysqli, $servername, $username, $password, $dbname, 3306)) {
  $response_array['error'] = "Connect Error: " . mysqli_connect_error();
  echo json_encode($response_array);
  return;
 }
  
 $sql = "DELETE FROM product WHERE productId = '".$_POST["productID"]."'";
 
 if ($mysqli->query($sql) === TRUE) {
   //echo "New record created successfully";
 } else {
  $response_array['error'] = 'Error deleting product: '.mysqli_error();
 }
 
 if($response_array['error'] == NULL) {
  //$response_array['error'] = 'Connected to Database!';
  
    $sql_queryTable = "SELECT productId, productName, quantity FROM product";
    mysqli_select_db($mysqli, $dbname);
    $result = mysqli_query($mysqli, $sql_queryTable);

    if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {
        $result_table .= "<tr><td>" . $row["productId"]. "</td><td>" . $row["productName"]. "</td><td>" . $row["quantity"]. "</td></tr>";
      }
    } else {
      $result_table = "";
    }
    
  }


 $response_array["query"] = $result_table;
 echo json_encode($response_array);

 $mysqli->close();
  
?>