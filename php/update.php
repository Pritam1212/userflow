<?php 
    require "config.php";

    if(isset($_POST['action']) && $_POST['action'] == 'update'){
        $fname = checkIn($_POST['firstname']);
        $lname = checkIn($_POST['lastname']);
        $email = checkIn($_POST['email']);
        $mobile = checkIn($_POST['mobile']);
        $dob = checkIn($_POST['dob']);
        $age = checkIn($_POST['age']);
        $address =  htmlspecialchars($_POST['address']);

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
            // echo $_POST['oid'];
            // $bulk->delete(['_id' => new MongoDB\BSON\ObjectID($_POST['oid'])], ['limit' => 1]);
            // $bulk->insert($data);
            $bulk->update(['_id' => new MongoDB\BSON\ObjectID($_POST['oid'])], ['$set' => $data]);
            $mongo->executeBulkWrite('registered_users
.users', $bulk);
        
            echo "Profile updated successfully!";

    }

    function checkIn($in){
        $in = trim($in);
        $in = stripslashes($in);
        $in = htmlspecialchars($in);

        return $in;
    }
?>