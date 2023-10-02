<?php
    
    require_once('includes/conn.php');
 
    // fetching the ID of the current user
    $active_user_id = (int) $_SESSION['user_id']; 

    // fetch the chats
    $query = "SELECT * FROM messages WHERE receiver_id='$active_user_id'";
    $result = mysqli_query($my_conn, $query);
    $n_row = (int) mysqli_num_rows($result);   
    if ($n_row > 0) {  $data = array();

           // GET NUM MESSAGES RECEIVED
           $xyz = "SELECT * FROM messages WHERE receiver_id='$active_user_id' AND status='sent'";
           $rsx = mysqli_query($my_conn, $xyz);
           $num_all_msg = (int) mysqli_num_rows($rsx); 

            while ($rd=mysqli_fetch_assoc($result)) {
            $sender_id = (int) $rd['sender_id'];     $status = $rd['status'];

            if ($status=='sent') { 
                // GET MESSAGES DATA FOR THIS SENDER
                $qry = "SELECT * FROM messages WHERE sender_id='$sender_id' AND receiver_id='$active_user_id' AND status='sent'";
                $rs = mysqli_query($my_conn, $qry);
                $nr = (int) mysqli_num_rows($rs); 
             } else {
                $nr = 0;
             }

             
             $data[] = [$sender_id, $nr];  
            } 

        $response =  ['status'=> 200, 'data'=>$data, 'msg_count'=>$num_all_msg];
    } else {
        $response =  ['status'=> 200, 'data'=>null, 'msg_count'=>0]; 
    }

    echo json_encode($response);