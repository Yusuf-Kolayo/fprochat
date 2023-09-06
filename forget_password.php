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

echo '<pre>';
var_dump($mail);
echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="bootstrap-5.3.0/css/bootstrap.min.css">
    <?php

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
                
                   
                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'user@example.com';                     //SMTP username
                        $mail->Password   = 'secret';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    
                        //Recipients
                        $mail->setFrom('from@example.com', 'Mailer');
                        $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                        $mail->addAddress('ellen@example.com');               //Name is optional
                        $mail->addReplyTo('info@example.com', 'Information');
                        $mail->addCC('cc@example.com');
                        $mail->addBCC('bcc@example.com');
                    
                        //Attachments
                        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                    
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Here is the subject';
                        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    
                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }                   //Enable verbose debug output
               
            } else {
                $msg = 'This email does not exist in our records';
            }
       }


   ?>
</head>
<body class="bg-dark">
    <br> <br> <br>

    <div class="row p-5">
          <div class="mx-auto col-md-5 bg-white p-2 rounded">
                    <h1 class="text-center border bg-dark rounded p-2 h5 mb-4 text-primary">Fpro Chat - Password Reset</h1> 
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
                                     <td><input class="btn btn-primary w-100" type="reset" value="Clear" /></td>
                                     <td> <button class="btn btn-secondary w-100" type ="submit" name="submit" >Submit</button></td>
                                </tr>
                                
                          </table>
                        

                      </form>
          </div>
    </div>

</body>
</html>