<?php
error_reporting(0);

$servername = $_POST["servername"];
$username = $_POST["username"];
$password = $_POST["password"];
$dbname = "demo";


$mysqli = mysqli_init();
$mysqli->ssl_set(NULL, NULL, '/etc/ssl/mysql/rds-combined-ca-bundle.pem', NULL, 'DHE-RSA-AES256-SHA');
$mysqli->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

if (!mysqli_real_connect ($mysqli, $servername, $username, $password)) {
  $response_array['error'] = "Connect Error: " . mysqli_connect_error();
  echo json_encode($response_array);
  return;
 }
 

 $db_check = mysqli_select_db($mysqli, $dbname);

 if(!$db_check) {
  $sql_createDb = "CREATE DATABASE ".$dbname;
  
  if (mysqli_query($mysqli, $sql_createDb)) {

    mysqli_select_db($mysqli, $dbname);
    $sql_createTable = "CREATE TABLE product (productId int(4) PRIMARY KEY AUTO_INCREMENT, productName varchar(50) NOT NULL, quantity int NOT NULL)";
    
    if (mysqli_query($mysqli, $sql_createTable)) {

    } else {
      $response_array['error'] = 'Error creating table: '.mysqli_error();
    }

  } else {
    $response_array['error'] = 'Error creating database: '.mysqli_error();
  }

 }

 if($response_array['error'] == NULL) {
  //$response_array['status'] = 'Connected to Database!';
  
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