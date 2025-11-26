<?php
    $server = "localhost";
    $username = "efitzpatrick_wildroseadmin";
    $password = "EQ^AlcHACBa_Lq7)";
    $database = "efitzpatrick_wildrosefoundry";

    $connection = mysqli_connect($server,$username,$password,$database);
    if(!$connection){
        die(mysqli_connect_error());
    }
?>