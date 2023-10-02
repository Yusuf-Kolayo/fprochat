<?php   require_once('user/includes/conn.php');

 if ($_SESSION['rs_email']==''||is_null($_SESSION['rs_email'])) { header('location:forget_password.php'); }
 
 $rs_email = $_SESSION['rs_email'];

 if (isset($_POST['submit'])) {  
    $email = sanitize_var($my_conn, $_POST['email']);
    $token = sanitize_var($my_conn, $_POST['token']);

    // check the exitence of the email in the database
     // check if the email is already registered
     $query = "SELECT * FROM users WHERE email=?";
     $stmt = mysqli_prepare($my_conn, $query);       // prrepare the sql statement
     mysqli_stmt_bind_param($stmt, "s", $email);     // bind the parameters
     mysqli_stmt_execute($stmt);                     // execute the prepared statement
     $result = mysqli_stmt_get_result($stmt);        // get execution results 
     $n_row1 = mysqli_num_rows($result);             // get the number of rows returned

     if ($n_row1 > 0) {

        $_query = "SELECT * FROM otp_tokens WHERE token=?";
        $_stmt = mysqli_prepare($my_conn, $_query);       // prrepare the sql statement
        mysqli_stmt_bind_param($_stmt, "s", $token);     // bind the parameters
        mysqli_stmt_execute($_stmt);                     // execute the prepared statement
        $_result = mysqli_stmt_get_result($_stmt);        // get execution results 
        $_n_row1 = mysqli_num_rows($_result);             // get the number of rows returned
   
        if ($_n_row1 > 0) {   
              $rdd = mysqli_fetch_assoc($_result);

              $time_sent =  $rdd['timestamp'];   $now = time();
              $diff_sec = $now-$time_sent;  // var_dump($time_sent); 
              if ($diff_sec<300) {  
                  $_SESSION['token_validated'] = 'true';
                  header('location:password_reset.php');     
                             
              } else {
                 $msg = 'The token entered has expired!';
              }
        } else {
            $msg = "The token entered is invalid";
        }
        
     } else {
         $msg = 'This email does not exist in our records';
     }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Token</title>
    <link rel="stylesheet" href="bootstrap-5.3.0/css/bootstrap.min.css">
    
</head>
<body class="bg-dark text-white">
    <br> <br> <br>

    <div class="row p-5">
          <div class="mx-auto col-md-5 bg-white p-2 rounded">
                    <h1 class="text-center border bg-dark rounded p-2 h5 mb-4 text-primary">Token Validation</h1> 
                    <?php
                    if ($msg!='') { echo '<div class="alert alert-primary">'.$msg.'</div>'; }
                    ?> 
                    <form action="" method="POST" class="mb-0">
                          <table class="table table-dark table-bordered border-primary mb-0">
                                <tr>
                                    <td colspan="2"> <p class="mb-0 text-center"><label for="">Enter the token sent to your mailbox, check your junk folders too.</label></p> </td>
                                </tr>
                                <tr>
                                   <td> <label for="" class="form-label">Email</label> </td>
                                   <td> 
                                         <input required type="email" name="email" id="" readonly value="<?php echo  $rs_email?>" class="form-control">
                                  </td>
                                </tr> 
                                <tr>
                                   <td> <label for="" class="form-label">Token</label> </td>
                                   <td> 
                                         <input required type="text" name="token" id="" class="form-control">
                                  </td>
                                </tr> 
                                <tr>
                                     <td><input class="btn btn-primary w-100" type="reset" value="Clear" /></td>
                                     <td> <button class="btn btn-secondary w-100" type ="submit" name="submit" >Submit</button></td>
                                </tr>
                                
                          </table>
                        

                      </form>
          </div>
    </div>

</body>
</html>