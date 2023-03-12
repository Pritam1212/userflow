<?php 
    require "config.php";

    if(isset($_POST['action']) && $_POST['action'] == 'register'){
        $fname = checkIn($_POST['firstname']);
        $lname = checkIn($_POST['lastname']);
        $email = checkIn($_POST['email']);
        $mobile = checkIn($_POST['mobile']);
        $dob = checkIn($_POST['dob']);
        $age = checkIn($_POST['age']);
        $pass = checkIn($_POST['password']);
        $cpass = checkIn($_POST['cpassword']);
        $address =  htmlspecialchars($_POST['address']);

        $pass = sha1($pass);
        $cpass = sha1($cpass);

        if($pass != $cpass){
            echo "Passwords did not match";
            exit();
        }else{
            // mysql conn

            $sql = $conn->prepare("SELECT email FROM users WHERE email=?");
            $sql->bind_param("s", $email);
            $sql->execute();
            $result = $sql->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if(isset($row['email']) && $row['email']==$email){
                echo "E-mail already exists. Try to login!";
            }else{
                $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $pass);
                if($stmt->execute()){
                    echo "Registered successfully. Login Now!";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }

            //mongo conn
            $data = array(
                'firstName' => $fname,
                'lastName' => $lname,
                'email' => $email,
                'mobile' => $mobile,
                'address' => $address,
                'dob' => $dob,
                'age' => $age,
            );
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->insert($data);
            $mongo->executeBulkWrite('registered_users
.users', $bulk);
        
        }


    }

    function checkIn($in){
        $in = trim($in);
        $in = stripslashes($in);
        $in = htmlspecialchars($in);

        return $in;
    }
?>