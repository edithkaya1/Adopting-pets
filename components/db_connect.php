<?php 
try {
   $hostname = "127.0.0.1"; 
   $username = "root"; 
   $password = ""; 
   $dbname = "BE23_EXAM5_animal_adoption_edithpeschke";
   // create connection, you need to be aware of the order of the parameters
   $connect = new mysqli($hostname, $username, $password, $dbname);
   // echo"connected successfully";
} catch (mysqli_sql_exception $e) {
   echo "Failed to connect to the database: ". $e->getMessage() ."";
}







