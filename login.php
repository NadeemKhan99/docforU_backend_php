<?php

include 'connection.php';


$obj = json_decode(file_get_contents('php://input'));   
$email = $obj->id;
$password = $obj->password;
$status = "active";
// $email = "abcd@gmail.com";
// $password = "12345678";


// Check if user is exit already or not-------------

$query = "SELECT * FROM admin_login WHERE email='$email' AND status= '$status'";

$result=mysqli_query($check_conn,$query);
$num=mysqli_num_rows($result);

if($num)
{
    $row=$result->fetch_assoc();
    if($row['password']==$password)
    {


        //  getting doctor reegister data

        $message = "Login Successfully!";
        
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $retObj=(object)["signal"=>1,"id"=>$message,"name"=>$name,"password"=>$password,"email"=>$email];
        echo json_encode($retObj);
    }
    else{
        $message="Invalid password or email!";
        $retObj=(object)["signal"=>2,"id"=>$message];
        echo json_encode($retObj);
    }
    
}
else
{

    //  count number of rows for unique category id----------

    
    $message="Email not found. Plz sign up as a user!";
    $retObj=(object)["signal"=>2,"id"=>$message];
    echo json_encode($retObj);
      

    

}


?>