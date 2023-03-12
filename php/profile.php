 <?php 
    require "config.php";

    if ($redis->exists($_COOKIE['email'])) {

        $user_data = unserialize($redis->get($_COOKIE['email']));                    

        if ($_COOKIE['token'] == $user_data['token']) {                 
            echo "Authenticated!";
        } else {
            echo "Invalid token.";
        }
    } else {
            echo "Access denied.";
    }                         

?>