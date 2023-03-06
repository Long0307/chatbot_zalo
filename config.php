<?php
    $host = "localhost:3306";
    $user = "root";
    $pass = "";
    $dbname = "appapi";

    $conn = mysqli_connect($host,$user,$pass,$dbname);

    if($conn){
        echo "Kết nối thành công";
    }

?>