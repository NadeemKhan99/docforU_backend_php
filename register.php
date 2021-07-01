<?php

include 'connection.php';


$obj = json_decode(file_get_contents('php://input'));   
$name = $obj->name;
$email = $obj->email;
$password = $obj->password;
$status = "active";

// Check if user is exit already or not-------------

$query = "SELECT * FROM admin_login WHERE email='$email'";

$result=mysqli_query($check_conn,$query);
$num=mysqli_num_rows($result);

if($num)
{
    $message = "User already exits! Try to login...";
    $retObj=(object)["id"=>$message,"signal"=>1];
    echo json_encode($retObj);
}
else
{

        if(!empty($email))
        {
            $insert_query = "INSERT INTO admin_login(name,email,password,status)VALUES('$name','$email','$password','$status')";
                        
            $result=mysqli_query($check_conn,$insert_query);
            if($result)
            {
                // mysqli_close($check_conn);
                $message="Account created successfully!";
                $retObj=(object)["id"=>$message,"signal"=>2];
                echo json_encode($retObj);
            }
            else{
                $message = "Unsuccessfull, Try again later!";
                echo $message;
                $retObj=(object)["id"=>$message,"signal"=>1];
                echo json_encode($retObj);
            }
        }
    
        
    
        

        
    

    

}




?>