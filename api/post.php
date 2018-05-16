<?php
    require(dirname(__FILE__) . '/../settings.php');
    require(dirname(__FILE__) . '/api.php');
    
    function is_set($thing, $name) {
        if(isset($thing)) {
            return true;
        } else {
            print("Error: " . $name . " is not set!");
            return false;
        }
    }
    
    function correctPassword($password) {
        global $websitePassword;
        
        if($password == $websitePassword) {
            return true;
        } else {
            print("Error: Incorrect password!");
            return false;
        }
    }
    
    function dateNotNull($date) {
        if($date != "0000-00-00") {
            return true;
        } else {
            print("Error: Invalid date!");
            return false;
        }
    }
    
    $id = $_POST['id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $pass = $_POST['password'];
    
    if(is_set($id, "ID") && is_set($date, "Date") && is_set($pass, "Password") && is_set($time, "Time") && correctPassword($pass) && dateNotNull($date)) {
        $mysql = get_mysql();
        
        $query = $mysql -> query("SELECT time_out FROM ll_log WHERE date='{$date}' AND id={$id} AND time_in IS NULL;");
        
        $result = null;
        
        if($query && mysqli_num_rows($query) > 0) {
            $time_in = $time;
            $result = $query -> fetch_assoc();
            $time_out = $result["time_out"];
            $result = $mysql -> query("UPDATE ll_log SET time_in={$time} WHERE date='{$date}' AND id={$id} AND time_in IS NULL;");
        } else {
            $result = $mysql -> query("INSERT INTO ll_log VALUES ({$id}, '{$date}', {$time}, NULL);");
        }
        
        if($result) {
            print "Success!";
        } else {
            print "Error";
        }
    }
?>