<?php
    require(dirname(__FILE__) . '/../settings.php');
    require(dirname(__FILE__) . '/api.php');
    
    global $websitePassword;
    $id = $_POST['id'];
    $date = $_POST['date'];
    $time_out = $_POST['time_out'];
    $time_in = $_POST['time_in'];
    $pass = $_POST['password'];
    
    if(isset($id) && isset($date) && isset($pass) && $pass == $websitePassword) {
        $mysql = get_mysql();
        
        if(!isset($time_in)) {
            $time_in = null;
        }
        
        $result = $mysql -> query("INSERT INTO ll_log VALUES ({$id}, '{$date}', {$time_out}, {$time_in});");
        
        if($result) {
            print "Success!";
        } else {
            print "Error";
        }
    }
?>