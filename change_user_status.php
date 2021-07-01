<?php

include 'connection.php';



$obj = json_decode(file_get_contents('php://input'));   
$email = $obj->user_id;
$password = $obj->status;
$user = $obj->user;

// $email = "user_1";
// $password = "cancel";

if(!empty($email))
{


    if($user == 5)
    {
        $query = "UPDATE admin_login SET status='$password' WHERE email='$email'";
    }
    else{
        $query = "UPDATE all_user SET status='$password' WHERE user_id='$email'";
    }




    $result=mysqli_query($check_conn,$query);
    
    
    if($result)
    {
    
        $message = "Updated Successfully!";
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