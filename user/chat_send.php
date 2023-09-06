<?php   require_once('includes/conn.php');   

    $partner_id = (int) $_POST['partner_id'];   
    if ($partner_id>0) { 

        // fetching the ID of thrn current user
        $active_user_id = (int) $_SESSION['user_id'];

        $message =  sanitize_var($my_conn, $_POST['input_txt']);   

        // FETCH USER DATA
        $_sql = "SELECT * FROM users WHERE id='$partner_id'";
        $_result = mysqli_query($my_conn, $_sql);
        $_n_row = mysqli_num_rows($_result);  
        if ($_n_row > 0) { 
            
            $_row = mysqli_fetch_array($_result);
            $first_name = $_row['first_name'];       $last_name = $_row['last_name'];
            $full_name = "$first_name $last_name";   $msg_type='text';  $status='sent';
            $timestamp = time();

            $channel1 = $active_user_id.'_'.$partner_id;
            $channel2 = $partner_id.'_'.$active_user_id;
    
            // fetch the chats
            $sql = "INSERT INTO messages (sender_id, receiver_id, channel, msg_type, message, status, timestamp) VALUES(?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($my_conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $active_user_id, $partner_id, $channel1, $msg_type, $message, $status, $timestamp);
            mysqli_stmt_execute($stmt);
            $n_row = mysqli_stmt_affected_rows($stmt);
            if ($n_row > 0) {  echo $partner_id;
                 $data = ['message'=>$message, 'timestamp'=>$timestamp];
                 $response =  ['status'=> 200, 'sent'=>'true', 'data'=>$data];
                 echo json_encode($response);
            } else {
                 $response =  ['status'=> 200, 'sent'=>'false', 'data'=>null];
                 echo json_encode($response);
                //   echo 'No chats found';
            }

        }

    } else {
        echo 'Error: something went wrong';
    }