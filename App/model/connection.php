<?php

try{

    $db= new mysqli("localhost","root","","b_inventory");

    
}catch(Exception $e){

    echo $e->getMessage();
    
}


?>