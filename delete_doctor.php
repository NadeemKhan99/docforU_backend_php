<?php

include 'connection.php';



$obj = json_decode(file_get_contents('php://input'));   
$user_id = $obj->user_id;
$hospital_email = $obj->hospital_id;
$status = $obj->status;

if($status == "active")
{
    $status = "cancel";
}
else{
    $status = "active";
}


if(!empty($user_id))
{
    $query = "SELECT clinic from doctor WHERE user_id='$user_id'";
    $result=mysqli_query($check_conn,$query);
    
    
    if($result)
    {

        $row = $result->fetch_assoc();

        $clinic = $row["clinic"];


        if($status == "cancel")
        {
            $appointments_status = "UPDATE appointment SET status='$status' WHERE doctor_id = '$user_id' AND hospital_id IN (SELECT user_id from all_user WHERE email='$hospital_email')";
            $appoint_query=mysqli_query($check_conn,$appointments_status);
        }



        
        if($clinic == "nothing")
        {



        


            $query_del_doc = "UPDATE all_user SET status='$status' WHERE user_id='$user_id'";
            
            $result1=mysqli_query($check_conn,$query_del_doc);

            if($result1)
            {
                    $query_del_doc1 = "UPDATE hospital_doc SET status='$status' WHERE doctor_id = '$user_id' AND hospital_id IN (SELECT user_id from all_user WHERE email='$hospital_email')";
                    $result2=mysqli_query($check_conn,$query_del_doc1);


                    $message = "Doctor updated successfully!";
                    $retObj=(object)["signal"=>1,"id"=>$message];
                    echo json_encode($retObj);

                
            }
        }
        else{

                    $query_del_doc1 = "UPDATE hospital_doc SET status='$status' WHERE doctor_id = '$user_id' AND hospital_id IN (SELECT user_id from all_user WHERE email='$hospital_email')";
                    $result2=mysqli_query($check_conn,$query_del_doc1);


                    $message = "Doctor updated successfully!";
                    $retObj=(object)["signal"=>1,"id"=>$message];
                    echo json_encode($retObj);

        }
    
        
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