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
        return $mysql -> query("SELECT * FROM ll_log WHERE id='$id';");
        // $mysql -> query("CREATE TABLE IF NOT EXISTS ll_log (id INTEGER, date DATE, time_out INTEGER, time_in INTEGER DEFAULT NULL);");
    }

    function get_dates($date) {
        $mysql = get_mysql();
        
        $mm = explode('/', $date)[0];
        $dd = explode('/', $date)[1];
        $yyyy = explode('/', $date)[2];
        
        return $mysql -> query("SELECT * FROM ll_log WHERE date='{$yyyy}-{$mm}-{$dd}';");
    }
    
    function get_datetime($date, $time) {
        $mysql = get_mysql();
        
        $mm = explode('/', $date)[0];
        $dd = explode('/', $date)[1];
        $yyyy = explode('/', $date)[2];
        
        $t = convertTimeToMin($time);
        
        return $mysql -> query("SELECT * FROM ll_log WHERE date='{$yyyy}-{$mm}-{$dd}' AND time_out < {$t} AND time_in > {$t};");
    }
    
    function get_times($time) {
        $mysql = get_mysql();
        
        $t = convertTimeToMin($time);
        
        return $mysql -> query("SELECT * FROM ll_log WHERE time_out < {$t} AND time_in > {$t};");
    }
    
    function convertToUSDate($date) {
        $mm = explode('/', $date)[0];
        $dd = explode('/', $date)[1];
        $yyyy = explode('/', $date)[2];
        
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
    
    function parseTime($minutes, $_12hour) {
        $time = floor($minutes / 60) . ':' . $minutes % 60;
        
        if($_12hour) {
            $hours = intval(explode(':', $time)[0]);
            $mins = intval(explode(':', $time)[1]);
            
            if($hours >= 12) {
                return $hours - 12 . ':' . $mins . ' PM';
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
        
        if(isset($_COOKIE['auth']) && $_COOKIE['auth'] == true) {
            return true;
        } else {
            redirect('login.php');
        }
    }
?>
