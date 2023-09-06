<?php   require_once('includes/conn.php');   

    

    $partner_id = (int) $_GET['user_id'];   
    if ($partner_id>0) {    

        // fetching the ID of thrn current user
        $active_user_id = (int) $_SESSION['user_id'];

        // FETCH USER DATA
        $_sql = "SELECT * FROM users WHERE id='$partner_id'";
        $_result = mysqli_query($my_conn, $_sql);
        $_n_row = mysqli_num_rows($_result);  
        if ($_n_row > 0) { // echo $partner_id;
            
            $_row = mysqli_fetch_array($_result);
            $first_name = $_row['first_name'];    $last_name = $_row['last_name'];    
            $full_name = "$first_name $last_name";                                

            $channel1 = $active_user_id.'_'.$partner_id;
            $channel2 = $partner_id.'_'.$active_user_id;

            // echo "$channel1 - $channel2";
    
            // fetch the chats
            $sql = "SELECT * FROM messages WHERE channel='$channel1' OR channel='$channel2' ORDER BY id ASC";
            $result = mysqli_query($my_conn, $sql);
            $n_row = (int) mysqli_num_rows($result);   
            if ($n_row > 0) {  $data = array();

                while($row = mysqli_fetch_array($result)) {
                    $msg = $row['message'];               $sender_id = $row['sender_id'];              $status = $row['status'];
                    $timestamp = $row['timestamp'];       $time = date('h:i:sa d-m-Y', $timestamp);    $msg_type = $row['msg_type'];
             
                    if ($status=='sent') {
                        $eye = '<img src="../ionicons_designerpack/checkmark.svg" width="10" alt="">';
                    } else {
                        $eye = '<img src="../ionicons_designerpack/checkmark-done.svg" width="10" alt="">';
                    }


                    if ($msg_type=='text') {
                        $msg_html = '<span>'.$msg.'</span>';
                    } else {
                        $msg_html = '<img src="uploads/chat_img/'.$msg.'" class="rounded w-100" />';
                    }

               

                   if ($sender_id==$active_user_id) { 
                        echo '<p class="comp mb-1">
                                 '.$msg_html.' 
                                 <span class="tmcomp"> <b style="font-size:12px;">'.$eye.' you:</b>  <br> '.$time.' </span>
                             </p>';
                   } else {
                        echo '<p class="cust mb-1">
                                 '.$msg_html.' 
                                 <span class="tmcus">  <b style="font-size:12px;"> '.$last_name.'</b><br> '.$time.'</span>
                              </p>';
                   }


                 }
    
    
                 
            } else {
                 $response =  ['status'=> 200, 'data'=>null, 'msg_count'=>0, 'fullname'=>$full_name];
                //  echo json_encode($response);
                  echo '<p class="my-4 text-center">no chats found</p>';
            }

        }




    } else {
        echo 'Error: something went wrong';
    }













//  require_once('includes/conn.php');   

//     $partner_id = (int) $_GET['user_id'];   
//     if ($partner_id>0) {    

//         // fetching the ID of thrn current user
//         $active_user_id = (int) $_SESSION['user_id'];

//         // FETCH USER DATA
//         $_sql = "SELECT * FROM users WHERE id='$partner_id'";
//         $_result = mysqli_query($my_conn, $_sql);
//         $_n_row = mysqli_num_rows($_result);  
//         if ($_n_row > 0) { // echo $partner_id;
            
//             $_row = mysqli_fetch_array($_result);
//             $first_name = $_row['first_name'];    $last_name = $_row['last_name'];
//             $full_name = "$first_name $last_name"; 

//             $channel1 = $active_user_id.'_'.$partner_id;
//             $channel2 = $partner_id.'_'.$active_user_id;

//             // echo "$channel1 - $channel2";
    
//             // fetch the chats
//             $sql = "SELECT * FROM messages WHERE channel=? OR channel=? ORDER BY id DESC";
//             $stmt = mysqli_prepare($my_conn, $sql);
//             mysqli_stmt_bind_param($stmt, "ss", $channel1, $channel2);
//             mysqli_stmt_execute($stmt) or die(mysqli_error($connection));
//             $n_row = (int) mysqli_stmt_num_rows($stmt);   
//             if ($n_row > 0) {  $data = array();
//                 $result = mysqli_stmt_get_result($stmt); 
    
//                 while($row = mysqli_fetch_array($result)) {
//                     $msg = $row['message'];
//                     $timestamp = $row['timestamp'];    
             
//                     $data[] = [$msg, $timestamp]; 
//                  }
    
    
//                  $response =  ['status'=> 200, 'data'=>$data, 'msg_count'=>$n_row, 'fullname'=>$full_name];
//                  echo json_encode($response);
//             } else {
//                  $response =  ['status'=> 200, 'data'=>null, 'msg_count'=>0, 'fullname'=>$full_name];
//                  echo json_encode($response);
//                 //   echo 'No chats found';
//             }

//         }




//     } else {
//         echo 'Error: something went wrong';
//     }