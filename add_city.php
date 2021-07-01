<?php

include 'connection.php';



$obj = json_decode(file_get_contents('php://input'));   
$data = $obj->user_id;

// $email = "user_1";
// $password = "cancel";

if(!empty($data))
{
    $query = "INSERT into cities (city)values('$data')";
    $result=mysqli_query($check_conn,$query);
    
    
    if($result)
    {
    
        $message = "Entered Successfully!";
        $retObj=(object)["signal"=>1,"id"=>$message];
        echo json_encode($retObj);
    }
    
    else{
        $message = "Try Again Later!";
        $retObj=(object)["signal"=>2,"id"=>$message];
        echo json_encode($retObj);
    }
    
}

    else{
        $message="Unsuccessfull, plz try again later!";
        $retObj=(object)["signal"=>2,"id"=>$message];
        echo json_encode($retObj);
    }

    
        
?>