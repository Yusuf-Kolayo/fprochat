<?php   require_once('user/includes/conn.php');

$first_name = null;  
$last_name  = null;
$email      = null;
$password   = null;
$gender     = null;
$msg        = null;



// the button submits successfully to server
// if (isset($_POST['btn_register'])) {  

//       $my_conn = mysqli_connect('localhost','root','','fpro_chat');

//       $first_name = mysqli_real_escape_string($my_conn, $_POST['first_name']) ;
//       $last_name = mysqli_real_escape_string($my_conn, $_POST['last_name']);
//       $email = mysqli_real_escape_string($my_conn, $_POST['email']);
//       $gender = mysqli_real_escape_string($my_conn, $_POST['gender']);
//       $password = mysqli_real_escape_string($my_conn, $_POST['password']);
//       $c_password = mysqli_real_escape_string($my_conn, $_POST['c_password']);

//       if ($password===$c_password) {
        
//         // hash the user password with the salts using the BCRYPT algorithm
//         $hashed_pword = password_hash( SALT_PREFIX .$password. SALT_SUFFIX, PASSWORD_BCRYPT);
 
//          // check if the email is already registered
//          $query = "SELECT id FROM users WHERE email='$email'";
//          $check = mysqli_query($my_conn, $query);
//          $n_row1 = mysqli_num_rows($check);
//          if ($n_row1>0) {
//                     $msg .= "This email already exist with us, login if you've registered before.";
//          } else {
//                     $sql = "INSERT INTO users (first_name,last_name,email,gender,password) 
//                             VALUES('$first_name','$last_name','$email','$gender','$hashed_pword')";
//                     $save = mysqli_query($my_conn, $sql);
//                     $n_row2 = mysqli_affected_rows($my_conn);
//                     if ($n_row2>0) {
//                         $msg .= 'Record saved successfully';
//                     } else {
//                         $msg .= 'Something went wrong, pls try again!';
//                     }
//          }

//       } else {
//          $msg .= 'Passwords does not match!';
//       }
// }






if (isset($_POST['btn_register'])) {
    
    $first_name = sanitize_var($my_conn, $_POST['first_name']);
    $last_name  = sanitize_var($my_conn, $_POST['last_name']);
    $email      = sanitize_var($my_conn, $_POST['email']);
    $gender     = sanitize_var($my_conn, $_POST['gender']);
    $password   = sanitize_var($my_conn, $_POST['password']);
    $c_password = sanitize_var($my_conn, $_POST['c_password']);

    if ($password === $c_password) {

        // Hash the user password with the salts using the BCRYPT algorithm
        $hashed_pword = password_hash(SALT_PREFIX . $password . SALT_SUFFIX, PASSWORD_BCRYPT);
        
        // Check if the email is already registered
        $query = "SELECT id FROM users WHERE email=?";
        $stmt = mysqli_prepare($my_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $n_row1 = mysqli_num_rows($result);

        if ($n_row1 > 0) {
            $msg .= "This email already exists with us. Please login if you've registered before.";
        } else {
            $sql = "INSERT INTO users (first_name, last_name, email, gender, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($my_conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $gender, $hashed_pword);
            mysqli_stmt_execute($stmt);
            $n_row2 = mysqli_stmt_affected_rows($stmt);
            if ($n_row2 > 0) {
                $msg .= 'Record saved successfully';
            } else {
                $msg .= 'Something went wrong, please try again!';
            }
        }
    } else { $msg .= 'Passwords do not match!'; }
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
                                    <td colspan="2">  <p class="mb-0 text-center"><label for="">Fill in the fields below to register</label></p>  </td>
                                </tr>
                                <tr>
                                     <td><label for="" class="form-label">Firstname</label></td>   
                                     <td> <input type="text" name="first_name" id="" value="<?php  echo $first_name?>" class="form-control"></td>
                                </tr>
                                <tr>
                                   <td>   <label for="" class="form-label">Lastname</label></td>
                                   <td>  <input type="text" name="last_name" id="" value="<?php echo  $last_name?>" class="form-control"></td>
                                </tr>
                                <tr>
                                   <td> <label for="" class="form-label">Email</label> </td>
                                   <td> 
                                         <input type="email" name="email" id="" value="<?php echo  $email?>" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                       <td><label for="" class="form-label">Gender</label></td>
                                       <td> 
                                            <select name="gender" id="" class="form-select">
                                                <option value=""></option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select> 
                                       </td>
                                </tr>
                                <tr>
                                   <td> <label for="" class="form-label">Password</label> </td>
                                   <td> 
                                         <input type="password" name="password" id="" value="<?php echo  $password?>" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                   <td> <label for="" class="form-label">Confirm Password</label> </td>
                                   <td> 
                                         <input type="password" name="c_password" id="" value="<?php echo  $password?>" class="form-control">
                                  </td>
                                </tr>
                                <tr>
                                     <td><input class="btn btn-primary w-100" type="reset" value="Clear" /></td>
                                     <td> <button class="btn btn-secondary w-100" type ="submit" name="btn_register" >Submit</button></td>
                                </tr>
                          </table>
                        

                      </form>
 
          </div>

          <p class="text-center text-white pt-4">Log in <a href="/">here</a> if you already own an account</p>
    </div>




</body>
</html>