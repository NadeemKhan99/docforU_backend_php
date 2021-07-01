<?php

include 'connection.php';


$obj = json_decode(file_get_contents('php://input'));  


$id = $obj->id;

$query = "SELECT * FROM doctor WHERE user_id = '$id'";

$result=mysqli_query($check_conn,$query);
$start = array();
$end = array();



//  doctors is done
if($result)
{
        $row = $result->fetch_assoc();

        $experience = $row["experience"];
        $fee = $row["fees"];
        $speciality = $row["speciality"];
        $qualification = $row["qualification"];
        $clinic = $row["clinic"];
        $timing = 1;

        if($clinic == "nothing")
        {
            $timing = 0;
        }
        else{

            $query_doctor_it = "SELECT * from timing WHERE user_id='$id'";
    

            $result_doctor = mysqli_query($check_conn,$query_doctor_it);
            
            if($result_doctor)
            {
                
                $row1 = $result_doctor->fetch_assoc();
                // $start = $row1['start'];
                array_push($start,$row1["start"]);
                // $end = $row1["end"];
                array_push($end,$row1["end"]);
            }
        }
       
    
}


//  hospital sitting----------


//   getting doctors of hospital---------------data[---------]

$hospital_id = array();
$names_hospital = array();
$counter = 0;


$query_hospital = "SELECT * from hospital_doc where doctor_id='$id'";
$query_hospital_run = mysqli_query($check_conn,$query_hospital);
$number_of_hospitals = mysqli_num_rows($query_hospital_run);

if($number_of_hospitals)
{

    while($row2 = mysqli_fetch_assoc($query_hospital_run))
    {

        array_push($hospital_id,$row2['hospital_id']);
        // array_push($start,$row2['start']);
        // array_push($end,$row2["end"]);
        $counter = $counter + 1;




    }

    $get_hospital_name_query = "SELECT hospital_name from hospital where user_id in (Select hospital_id from hospital_doc where doctor_id='$id')";
    $query_run = mysqli_query($check_conn,$get_hospital_name_query);

    while($row3 = mysqli_fetch_assoc($query_run))
    {


        array_push($names_hospital,$row3["hospital_name"]);




    }



}


if($result || $query_hospital_run)
{

    $retObj=(object)["signal"=>1,"counter"=>$counter,"experience"=>$experience,"fees"=>$fee,"qualification"=>$qualification,"speciality"=>$speciality,"clinic"=>$clinic,"start"=>$start,"end"=>$end,"hospital_name"=>$names_hospital];
            echo json_encode($retObj);

}
else{
    $message = "something went wrong!";
    $retObj = (object)["signal"=>2,"message"=>$message];
    echo json_encode($retObj);


}










?>