<?php

if(!isset($_SESSION)){
    session_start();
}


function Auth(){
    include('dbconnection.php');

    if(isset($_SESSION['username'])){
        
    }else{
        return(false);
    }

    $sql = "SELECT * FROM users WHERE username = " . $_SESSION['username'];

    $stmt = $dbconn->prepare($sql);
    $data = array();  
    $stmt->execute($data);
    $res = $stmt->fetchAll();

    if($res[0]['bannad'] == 0){

        return(true);
    
    }else{
        return(false);
    }
}

function Admin_Auth(){
    include('dbconnection.php');
    if(Auth()){
        $sql = "SELECT * FROM users WHERE username = " . $_SESSION['username'];

        $stmt = $dbconn->prepare($sql);
        $data = array();  
        $stmt->execute($data);
        $res = $stmt->fetchAll();
      
        if($res[0]['admin'] != 1){
    
            return(false);
        }else{
            return(true);
        }
    }
}



?>