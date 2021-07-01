<?php

include 'connection.php';



$obj = json_decode(file_get_contents('php://input'));  


$user = $obj->id;

$name = array();
$email = array();
$status = array();
$counter = 0;



    $query = "SELECT * FROM admin_login";




$result=mysqli_query($check_conn,$query);
$num=mysqli_num_rows($result);

if($num)
{



    while($row1 = mysqli_fetch_assoc($result))
    {
                    array_push($name,$row1['name']);
                    array_push($email,$row1['email']);
                    array_push($status,$row1['status']);
                    $counter = $counter + 1 ;               
    }
         

    $retObj=(object)["signal"=>1,"counter"=>$counter,"name"=>$name,"email"=>$email,"status"=>$status];
    echo json_encode($retObj);
}

else{
    $message = "Something went wrong!";
    $retObj=(object)["signal"=>2,"message"=>$message];
    echo json_encode($retObj);
}


    
        
?>