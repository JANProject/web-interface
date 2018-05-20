<?php
    function get_mysql() {
		global $ip, $username, $password, $dbname, $port;
        $mysql = new mysqli($ip, $username, $password, $dbname, $port);

        if($mysql -> connect_errno) {
            die($mysql -> connect_error);
        }

        return $mysql;
    }

    function get_student_info($id) {
        $mysql = get_mysql();
        $stmt = $mysql -> prepare("SELECT * FROM ll_log WHERE id=?;");
        $stmt -> bind_param('i', $id);
        $stmt -> execute();
        $results = $stmt -> get_result();
        $stmt -> close();
        $mysql -> close();
        
        return $results;
        // $mysql -> query("CREATE TABLE IF NOT EXISTS ll_log (id INTEGER, date DATE, time_out INTEGER, time_in INTEGER DEFAULT NULL);");
    }

    function get_dates($date) {
        $mysql = get_mysql();
        
        $stmt = $mysql -> prepare("SELECT * FROM ll_log WHERE date=?;");
        $stmt -> bind_param('s', $date);
        $stmt -> execute();
        $results = $stmt -> get_result();
        $stmt -> close();
        $mysql -> close();
        
        return $results;
    }
    
    function get_datetime($date, $time) {
        $mysql = get_mysql();
        
        $t = convertTimeToMin($time);
        
        $stmt = $mysql -> prepare("SELECT * FROM ll_log WHERE date=? AND time_out <= {$t} AND time_in >= {$t};");
        $stmt -> bind_param('s', $date);
        $stmt -> execute();
        $results = $stmt -> get_result();
        $stmt -> close();
        $mysql -> close();
        
        return $results;
    }
    
    function get_times($time) {
        $mysql = get_mysql();
        
        $t = convertTimeToMin($time);
        
        return $mysql -> query("SELECT * FROM ll_log WHERE time_out < {$t} AND time_in > {$t};");
    }
    
    function convertToUSDate($date) {
        $yyyy = explode('-', $date)[0];
        $mm = explode('-', $date)[1];
        $dd = explode('-', $date)[2];
        
        return "{$mm}/{$dd}/{$yyyy}";
    }
    
    function convertTimeToMin($time) {
        $hours = intval(explode(':', $time)[0]);
        $minutes = intval(explode(':', $time)[1]);
        
        return $hours * 60 + $minutes;
    }
    
    function convertTo12Hour($time) {
        $hours = intval(substr($time, 0, 2));
        $minutes = intval(substr($time, 3, 2));
            $amPM = " AM";
        
        if($hours >= 12) {
            $amPM = " PM";
        }
        
        if($hours > 12) {
            $hours -= 12;
        }
        
        return $hours . ":" . $minutes . $amPM;
    }
    
    function parseTime($minutes, $use12Hour) {
        if($minutes == null) {
            return "Hasn't returned";
        }
        
        $min = $minutes % 60;
        
        if($min < 10) {
            $min = "0" . $min;
        }
        
        $time = floor($minutes / 60) . ':' . $min;
        
        if($use12Hour) {
            $hours = intval(explode(':', $time)[0]);
            $mins = intval(explode(':', $time)[1]);
            
            if($mins < 10) {
                $mins = "0" . $mins;
            }
            
            if($hours > 12) {
                return $hours - 12 . ':' . $mins . ' PM';
            } else if($hours == 12) {
                return $hours . ':' . $mins . ' PM';
            } else {
                return $hours . ':' . $mins . ' AM';
            }
        } else {
            return $time;
        }
    }
      
    function redirect($location) {
        echo '<script>location.href = "' . $location . '"</script>';
    }
    
    function checkPassword() {
        global $websitePassword;
        
        if(isset($_COOKIE['auth']) && isset($_COOKIE['session']) && $_COOKIE['auth'] == true && password_verify($websitePassword, $_COOKIE['session'])) {
            return true;
        } else {
            setcookie('auth', false);
            setcookie('session', false);
            redirect('login.php');
        }
    }
?>
