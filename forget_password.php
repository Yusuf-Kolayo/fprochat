<?php   require_once('user/includes/conn.php'); 


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 
       if (isset($_POST['submit'])) {  
           $email = sanitize_var($my_conn, $_POST['email']);

           // check the exitence of the email in the database
            // check if the email is already registered
            $query = "SELECT * FROM users WHERE email=?";
            $stmt = mysqli_prepare($my_conn, $query);       // prrepare the sql statement
            mysqli_stmt_bind_param($stmt, "s", $email);     // bind the parameters
            mysqli_stmt_execute($stmt);                     // execute the prepared statement
            $result = mysqli_stmt_get_result($stmt);        // get execution results 
            $n_row1 = mysqli_num_rows($result);             // get the number of rows returned

            if ($n_row1 > 0) {

            
                $token_check = false;
                while ($token_check===false) {
                    $token = rand(100001, 999999);
                      // check if the token has not been generated before
                    $_sqx = "SELECT id FROM otp_tokens WHERE token='$token'";
                    $_res = mysqli_query($my_conn, $_sqx);
                    $_nr  = (int) mysqli_num_rows($_res);
                    if ($_nr==0) {
                        $token_check = true;

                        $timestamp = time();
                        // save the newly generatyed token
                        $sr = "INSERT INTO otp_tokens (token, status, email, timestamp) VALUES('$token', 'sent', '$email', '$timestamp')";
                        $result_2 = mysqli_query($my_conn, $sr);
                        $num_2 = mysqli_affected_rows($my_conn);
                        if ($num_2>0) {
                            

                             try {
                                //Server settings
                                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                                $mail->isSMTP();                                            //Send using SMTP
                                $mail->Host       = '';                     //Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                $mail->Username   = '';                     //SMTP username
                                $mail->Password   = '';                               //SMTP password
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                            
                                // Recipients
                                $mail->setFrom('fprochat@qatru.com', 'FproChat');
                                $mail->addAddress($email);     //Add a recipient
                                $mail->addReplyTo('fprochat@qatru.com', 'FproChat');
                            
                                //Content
                                $mail->isHTML(true);                                  //Set email format to HTML
                                $mail->Subject = 'FproChat Password Reset';
                                $mail->Body    = '<h2>Reset your password using the token below</h2><br><h1>'.$token.'</h1>';
                                $mail->AltBody = 'Reset your password using the token: '.$token;
                            
                                $mail->send();
                                $msg = 'An OTP has been sent to your mailbox, check it or your junk folders \n \n Note: the token expires in 5 minutes!';
                                $_SESSION['rs_email'] = $email;

                                echo '<script>alert("'.$msg.'"); window.location.href="validate_token.php"; </script>';

                            } catch (Exception $e) {
                                $msg =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            }       

                            
                        } 


                    }
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
    <title>Password Reset</title>
    <link rel="stylesheet" href="bootstrap-5.3.0/css/bootstrap.min.css">
    
</head>
<body class="bg-dark text-white">
    <br> <br> <br>

    <div class="row p-5">
          <div class="mx-auto col-md-5 bg-white p-2 rounded">
                    <h1 class="text-center border bg-dark rounded p-2 h5 mb-4 text-primary">Email Validation</h1> 
                    <?php
                    // ($msg!='') ? '<div class="alert alert-primary">'.$msg.'</div>' : ''
                    if ($msg!='') { echo '<div class="alert alert-primary">'.$msg.'</div>'; }
                    ?> 
                    <form action="" method="POST" class="mb-0">
                          <table class="table table-dark table-bordered border-primary mb-0">
                                <tr>
                                    <td colspan="2"> <p class="mb-0 text-center"><label for="">Enter your email address to proceed</label></p> </td>
                                </tr>
                                <tr>
                                   <td> <label for="" class="form-label">Email</label> </td>
                                   <td> 
                                         <input type="email" required name="email" id="" value="<?php echo  $email?>" class="form-control">
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