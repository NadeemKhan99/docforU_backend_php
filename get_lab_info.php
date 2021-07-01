<?php

include 'connection.php';


$obj = json_decode(file_get_contents('php://input'));  


$id = $obj->id;
// $id = "lab_19";

$query = "SELECT * FROM lab INNER JOIN timing ON lab.user_id = timing.user_id AND lab.user_id = '$id'";

$result=mysqli_query($check_conn,$query);




if($result)
{
        $row = $result->fetch_assoc();

        $services = $row["services"];
        $start = $row["start"];
        $end = $row["end"];
        $fee = $row["fee"];

        $retObj=(object)["signal"=>1,"services"=>$services,"start"=>$start,"end"=>$end,"fee"=>$fee];
        echo json_encode($retObj);

}
else{
    $message = "something went wrong!";
    $retObj = (object)["signal"=>2,"message"=>$message];
    echo json_encode($retObj);


}










?>