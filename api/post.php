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
    $time = intval($_POST['time']);
    $pass = $_POST['password'];
    
    if(is_set($id, "ID") && is_set($date, "Date") && is_set($pass, "Password") && is_set($time, "Time") && correctPassword($pass) && dateNotNull($date)) {
        $mysql = get_mysql();
        
        $stmt1 = $mysql -> prepare("UPDATE ll_log SET time_in=? WHERE date=? AND id=? AND time_in IS NULL;");
        $stmt1 -> bind_param('isi', $time, $date, $id);
        $worked = $stmt1 -> execute();
        
        if(!$worked || $stmt1 -> affected_rows == 0) {
            $stmt2 = $mysql -> prepare("INSERT INTO ll_log VALUES (?, ?, ?, NULL);");
            $stmt2 -> bind_param('isi', $id, $date, $time);
            $worked = $stmt2 -> execute();
            $stmt2 -> close();
        }
        
        $stmt1 -> close();
        
        // $uploaddir = "images/profiles/";
        // $uploadfile = $uploaddir . basename( $_FILES['file']['name']);
        
        // if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
        // {
        //   print "The file has been uploaded successfully\n";
        // }
        // else
        // {
        //   print "There was an error uploading the file\n";
        // }
        
        if($worked) {
            print "Success!";
        } else {
            print "Error";
        }
        
        $mysql -> close();
    }
?>