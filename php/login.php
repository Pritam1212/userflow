<?php 
    require "config.php";

    if(isset($_POST['action']) && $_POST['action'] == 'login'){
        $email = $_POST['email'];
        $pass = sha1($_POST['password']);

        // mysql conn

        $sql = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
        $sql->bind_param("ss", $email, $pass);
        $sql->execute();
        $user = $sql->fetch();

        if($user != null){
            $query = new MongoDB\Driver\Query(['email'=> $email],[]);
            $result = $mongo->executeQuery('registered_users
.users', $query);
            if($result){
                $res = $result->toArray()[0];
                $json = array(
                    "firstName" => $res->firstName,
                    "lastName" => $res->lastName,
                    "email" => $res->email,
                    "mobile" => $res->mobile,
                    "address" => $res->address,
                    "dob" => $res->dob,
                    "age" => $res->age,
                    "_id" => $res->_id,
                );

                //redis
                $user_data = [];
                $session_token = bin2hex(openssl_random_pseudo_bytes(16));
                $user_data['token'] = $session_token;
                $user_data['email'] = $res->email;

                setcookie('token', $session_token, time()+3600);
                setcookie('email', $user_data['email'], time()+3600);

                $redis_key =  $user_data['email'];

                $redis->set($redis_key, serialize($user_data)); 

                $redis->expire($redis_key, 3600); 
                
                // echo $res->_id;
                echo json_encode($json);
		    }
        }else{
                header('Location: ../login.html');

        }
    }


?>