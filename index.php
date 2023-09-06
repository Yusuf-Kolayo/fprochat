<?php   require_once('user/includes/conn.php');

$msg      = null;
$email      = null;
$password   = null; 


// the button submits successfully to server
// if (isset($_POST['btn_login'])) {  
 
//     $email    = mysqli_real_escape_string($my_conn, $_POST['email']); 
//     $password = mysqli_real_escape_string($my_conn, $_POST['password']); 


//        // check if the email is already registered
//        $query = "SELECT * FROM users WHERE email='$email'";
//        $check = mysqli_query($my_conn, $query);
//        $n_row1 = mysqli_num_rows($check);
//        if ($n_row1>0) {
//            $rd = mysqli_fetch_array($check);

//            $md_password = SALT_PREFIX .$password. SALT_SUFFIX;
//            if (password_verify($md_password, $rd['password'])===true) {

//                 // save user info in session 
//                 $_SESSION['first_name'] = $rd['first_name'];
//                 $_SESSION['last_name'] = $rd['last_name'];
//                 $_SESSION['email'] = $rd['email'];
//                 $_SESSION['gender'] = $rd['gender'];
//                 $_SESSION['user_id'] = $rd['id'];

//                  header('location:user/dashboard.php');
//            } else {
//                $msg = 'The credentials submitted does not match any of our records';
//            }

           
//        } else {
//          $msg = 'The credentials submitted does not match any of our records';
//        }
// }



if (isset($_POST['btn_login'])) {
   
    $email    = sanitize_var($my_conn, $_POST['email']);    // sanitizing users input
    $password = sanitize_var($my_conn, $_POST['password']);
    
    // check if the email is already registered
    $query = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($my_conn, $query);       // prrepare the sql statement
    mysqli_stmt_bind_param($stmt, "s", $email);     // bind the parameters
    mysqli_stmt_execute($stmt);                     // execute the prepared statement
    $result = mysqli_stmt_get_result($stmt);        // get execution results 
    $n_row1 = mysqli_num_rows($result);             // get the number of rows returned

    if ($n_row1 > 0) {
        $rd = mysqli_fetch_array($result);           // fetching a row from the result
        $md_password = SALT_PREFIX . $password . SALT_SUFFIX;
        if (password_verify($md_password, $rd['password']) === true) {

            // save user info in session
            $_SESSION['first_name'] = $rd['first_name'];
            $_SESSION['last_name'] = $rd['last_name'];
            $_SESSION['email'] = $rd['email'];
            $_SESSION['usr_type'] = $rd['usr_type'];
            $_SESSION['gender'] = $rd['gender'];
            $_SESSION['user_id'] = $rd['id'];

            header('location:user/dashboard.php');
        } else {
            $msg = 'The credentials submitted does not match any of our records';
        }
    } else {
        $msg = 'The credentials submitted does not match any of our records';
    }
}


    
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="bootstrap-5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-dark">
    <br> 
    

    <div class="row p-5">
          <div class="mx-auto col-md-5 bg-white p-2 rounded">
                    <h1 class="text-center border bg-dark rounded p-2 h5 mb-4 text-primary">Fpro Chat</h1>


                    <?php
                    // ($msg!='') ? '<div class="alert alert-primary">'.$msg.'</div>' : ''
                    if ($msg!='') { echo '<div class="alert alert-primary">'.$msg.'</div>'; }
                    ?> 
                    <form action="" method="POST" class="mb-0">
                          <table class="table table-dark table-bordered border-primary mb-0">
                                <tr>
                                    <td colspan="2"> <p class="mb-0 text-center"><label for="">Fill in the fields below to log in</label></p> </td>
                                </tr>
                                <tr>
                                   <td> <label for="" class="form-label">Email</label> </td>
                                   <td> 
                                         <input type="email" name="email" id="" value="<?php echo  $email?>" class="form-control">
                                  </td>
                                </tr>
                             
                                <tr>
                                   <td> <label for="" class="form-label">Password</label> </td>
                                   <td> 
                                         <input type="password" name="password" id="" value="<?php echo  $password?>" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                     <td><input class="btn btn-primary w-100" type="reset" value="Clear" /></td>
                                     <td> <button class="btn btn-secondary w-100" type ="submit" name="btn_login" >Submit</button></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                          <p class="mb-0 text-center">
                                              <a href="forget_password.php"> Forget Password</a>
                                          </p>
                                    </td>
                                </tr>
                          </table>
                        

                      </form>
          </div>
          <p class="text-center text-white pt-4">Register <a href="/register.php">here</a> if you don't own an account</p>
    </div>




</body>
</html>