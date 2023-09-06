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

            $response =  ['status'=> 200, 'first_name'=>$first_name, 'last_name'=>$last_name];
            echo json_encode($response);
   
            } else {
                 $response =  ['status'=> 200, 'first_name'=>null, 'last_name'=>null];
                 echo json_encode($response);
            }

 } else { echo 'Error: something went wrong'; }
