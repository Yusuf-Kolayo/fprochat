<?php   require_once('user/includes/conn.php');

 if ($_SESSION['token_validated']!='true'||is_null($_SESSION['token_validated'])) { 
    header('location:forget_password.php');
 }

 $rs_email = $_SESSION['rs_email'];



 if (isset($_POST['submit'])) {  
    $email = $_SESSION['rs_email'];

    $password1 = sanitize_var($my_conn, $_POST['password1']);
    $password2 = sanitize_var($my_conn, $_POST['password2']);

    if ($password1==$password2) {

        // Hash the user password with the salts using the BCRYPT algorithm
        $hashed_pword = password_hash(SALT_PREFIX . $password1. SALT_SUFFIX, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET password=? WHERE email=?";
        $stmt = mysqli_prepare($my_conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $hashed_pword, $email);
        mysqli_stmt_execute($stmt);
        $n_row2 = mysqli_stmt_affected_rows($stmt);
        if ($n_row2 > 0) {

            $_SESSION['rs_email'] = null;
            $_SESSION['token_validated'] = null;
            echo '<script>alert("Password updated successfully"); window.location.href="index.php"; </script>';
            
        } else {
            $msg = 'Something went wrong, please try again!';
        }
        
    } else {
        $msg = 'Passwords does not match!';
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
                    <h1 class="text-center border bg-dark rounded p-2 h5 mb-4 text-primary">Password Reset</h1> 
                    <?php
                    if ($msg!='') { echo '<div class="alert alert-primary">'.$msg.'</div>'; }
                    ?> 
                    <form action="" method="POST" class="mb-0">
                          <table class="table table-dark table-bordered border-primary mb-0">
                                <tr>
                                    <td colspan="2"> <p class="mb-0 text-center"><label for="">Now, set your new password</label></p> </td>
                                </tr>
                                <tr>
                                   <td> <label for="" class="form-label">Email</label> </td>
                                   <td> 
                                         <input required type="email" name="email" id="" readonly value="<?php echo  $rs_email?>" class="form-control">
                                  </td>
                                </tr> 
                                <tr>
                                   <td> <label for="" class="form-label">New Password</label> </td>
                                   <td> 
                                         <input required type="password" name="password1" id="" class="form-control">
                                  </td>
                                </tr> 
                                <tr>
                                   <td> <label for="" class="form-label">Repeat Password</label> </td>
                                   <td> 
                                         <input required type="password" name="password2" id="" class="form-control">
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