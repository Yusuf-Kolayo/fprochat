<?php   require_once('includes/conn.php');   

    $partner_id = (int) $_POST['partner_id'];   
    if ($partner_id>0) { 

        // fetching the ID of thrn current user
        $active_user_id = (int) $_SESSION['user_id'];



        if (isset($_FILES['input_img'])) {
            $file_name = $_FILES['input_img']['name'];
            $file_size = $_FILES['input_img']['size'];
            $file_type = $_FILES['input_img']['type'];
            $file_tmp_name = $_FILES['input_img']['tmp_name'];
            $new_file_name = $active_user_id.'_'. time().'_'. $file_name;
 
         
             $supported_types = [
               'image/jpeg',
               'image/jpg',
               'image/png',
               'image/webp'
             ];
             if (in_array($file_type, $supported_types)) {
                    if ($file_size<=2000000) {
                          $upload = move_uploaded_file($file_tmp_name, 'uploads/chat_img/'.$new_file_name);
                          if ($upload) {
                          
                            






                            

                                    // FETCH USER DATA
                                    $_sql = "SELECT * FROM users WHERE id='$partner_id'";
                                    $_result = mysqli_query($my_conn, $_sql);
                                    $_n_row = mysqli_num_rows($_result);  
                                    if ($_n_row > 0) { 
                                        
                                        $_row = mysqli_fetch_array($_result);
                                        $first_name = $_row['first_name'];       $last_name = $_row['last_name'];
                                        $full_name = "$first_name $last_name";   $msg_type='image';  $status='sent';
                                        $timestamp = time();

                                        $channel1 = $active_user_id.'_'.$partner_id;
                                        $channel2 = $partner_id.'_'.$active_user_id;
                                        $message  = $new_file_name;
                                
                                        // fetch the chats
                                        $sql = "INSERT INTO messages (sender_id, receiver_id, channel, msg_type, message, status, timestamp) VALUES(?,?,?,?,?,?,?)";
                                        $stmt = mysqli_prepare($my_conn, $sql);
                                        mysqli_stmt_bind_param($stmt, "sssssss", $active_user_id, $partner_id, $channel1, $msg_type, $message, $status, $timestamp);
                                        mysqli_stmt_execute($stmt);
                                        $n_row = mysqli_stmt_affected_rows($stmt);
                                        if ($n_row > 0) {  echo $partner_id;
                                            $data = ['message'=>$message, 'timestamp'=>$timestamp];
                                            $response =  ['status'=> 'success', 'sent'=>'true', 'data'=>$data];
                                            echo json_encode($response);
                                        } else {
                                            $response =  ['status'=> 'failed', 'sent'=>'false', 'data'=>'Something went wrong, pls try again'];
                                            echo json_encode($response);
                                            //   echo 'No chats found';
                                        }

                                    }












                          } else {
                            $response =  ['status'=> 'failed', 'sent'=>'false', 'data'=>'Something went wrong, pls try again'];
                            echo json_encode($response);
                          }
                    } else {
                        $response =  ['status'=> 'failed', 'sent'=>'false', 'data'=>'Filesize too large, must be lower than 2MB'];
                        echo json_encode($response); 
                    }
             } else {
                $response =  ['status'=> 'failed', 'sent'=>'false', 'data'=>'Unsupported file format/type'];
                echo json_encode($response);
             }
 
       }







    } else {
        $response =  ['status'=> 'failed', 'sent'=>'false', 'data'=>'Something went wrong, pls try again'];
        echo json_encode($response);
    }


    // echo '<pre>';
    //    print_r($_POST);
    //    print_r($_FILES);
    // echo '</pre>';