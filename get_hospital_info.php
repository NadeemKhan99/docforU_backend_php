<?php

include 'connection.php';


$obj = json_decode(file_get_contents('php://input'));  


$id = $obj->id;

$name = array();
$email = array();
$city = array();
$address = array();
$phone = array();
$user_id = array();
$status = array();

$active="active";
$counter = 0;




$query = "SELECT * FROM hospital WHERE user_id = '$id'";


$result=mysqli_query($check_conn,$query);




if($result)
{
        $row = $result->fetch_assoc();

        $hospital_name = $row["hospital_name"];
        $no_doc = $row["no_doctors"];
        $treated = $row["disease_treated"];


        //  get doctors status from hospital_doc

        $select_doc_status_query = "SELECT * from hospital_doc where hospital_id='$id'";
        $get_select_status = mysqli_query($check_conn,$select_doc_status_query);

        while($row3 = mysqli_fetch_assoc($get_select_status))
        {
            array_push($status,$row3['status']);
        }



        //   getting doctors info related to that hospital---------------

        $select_doc = "SELECT name,email,city,phone,address,user_id FROM all_user WHERE user_id IN (SELECT doctor_id from hospital_doc where hospital_id='$id')";
        $doc_query=mysqli_query($check_conn,$select_doc);

        while($row1 = mysqli_fetch_assoc($doc_query))
        {
                        array_push($name,$row1['name']);
                        array_push($email,$row1['email']);
                        array_push($phone,$row1['phone']);
                        array_push($city,$row1['city']);
                        array_push($address,$row1['address']);
                        array_push($user_id,$row1['user_id']);
                        $counter = $counter + 1 ;               
        }

        $retObj=(object)["signal"=>1,"hospital_name"=>$hospital_name,"no_doc"=>$no_doc,"treated"=>$treated,"name"=>$name,"email"=>$email,"city"=>$city,"address"=>$address,"phone"=>$phone,"counter"=>$counter,"user_id"=>$user_id,"status"=>$status];
        echo json_encode($retObj);

}
else{
    $message = "something went wrong!";
    $retObj = (object)["signal"=>2,"message"=>$message];
    echo json_encode($retObj);


}










?>