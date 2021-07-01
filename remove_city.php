<?php

include 'connection.php';



$obj = json_decode(file_get_contents('php://input'));   
$data = $obj->city;

// $email = "user_1";
// $password = "cancel";

if(!empty($data))
{
    $query = "DELETE from cities where city='$data'";
    $result=mysqli_query($check_conn,$query);
    
    
    if($result)
    {
    
        $message = "Deleted Successfully!";
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