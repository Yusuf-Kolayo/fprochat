<?php

   // checks if logged in or not 
   if (!(int) $_SESSION['user_id']>0) { header('location:../'); }


   if (isset($_POST['btn_signout'])) {  
      // delete all session data
      session_destroy();

      // redirect to login page
      header('location:../');
   }

?>