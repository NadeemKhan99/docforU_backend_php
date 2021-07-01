<?php

include 'connection.php';



$obj = json_decode(file_get_contents('php://input'));  


$user = $obj->id;

$name = array();
$email = array();
$phone = array();
$address = array();
$city = array();
$status = array();
$user_id = array();
$counter = 0;


if($user == 1) #patient
{
    $query = "SELECT * FROM all_user WHERE user_id LIKE 'user_%'";
}
elseif($user == 2) # doctor
{
    $query = "SELECT * FROM all_user WHERE user_id LIKE 'doctor_%'";
}
elseif($user == 3) # hospitals
{
    $query = "SELECT * FROM all_user WHERE user_id LIKE 'hospital_%'";
}
else # labs
{
    $query = "SELECT * FROM all_user WHERE user_id LIKE 'lab_%'";
}



$result=mysqli_query($check_conn,$query);
$num=mysqli_num_rows($result);

if($num)
{



    while($row1 = mysqli_fetch_assoc($result))
    {
                    array_push($name,$row1['name']);
                    array_push($email,$row1['email']);
                    array_push($phone,$row1['phone']);
                    array_push($city,$row1['city']);
                    array_push($address,$row1['address']);
                    array_push($status,$row1['status']);
                    array_push($user_id,$row1['user_id']); 
                    $counter = $counter + 1 ;               
    }
         

    $retObj=(object)["signal"=>1,"counter"=>$counter,"name"=>$name,"email"=>$email,"city"=>$city,"phone"=>$phone,"status"=>$status,"address"=>$address,"user_id"=>$user_id];
    echo json_encode($retObj);
}

else{
    $message = "Something went wrong!";
    $retObj=(object)["signal"=>2,"message"=>$message];
    echo json_encode($retObj);
}


    
        
?>