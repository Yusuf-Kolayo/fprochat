<?php  
require_once('includes/conn.php');   
require_once('header.php');

$user_id = $_SESSION['user_id'];
$server_host = $_SERVER['HTTP_HOST'];
$dummy_img_url = '/assets/img/dummy_user.webp';
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>Dashboard Template · Bootstrap v5.3</title>

    <link rel="stylesheet" href="../bootstrap-5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.css">
    <style>
        .cust { text-align: left;
          font-size: 14px; background-color: #74aaff; padding: 7px;
          color: #000; width: 85%; float: left; border-radius: 5px;
          }
          
          .tmcus{ font-size: .8em; float: right!important; }
          .tmcomp { font-size: .8em; float: right!important; }
          a { text-decoration: none!important; }

          .comp { text-align: left;
          font-size: 14px; background-color: #bedaff;
          color: #000; padding: 7px; width: 85%;
          float: right; border-radius: 5px;
          }
 
    </style>

    <style>
        .img_user{ border-radius: 50%; width: 30px;}
    </style>

     

     
  </head>
  <body class="bg-dark"> 

    <div class="container-fluid">
      <div class="row text-primary">  
        <main class="col-md-8 mx-auto text-primary"> 
        <?php require_once('nav.php');?>  <br> <br>



          <div class="pt-3 pb-2 mb-3">
            
            <div>
                      <!-- DIRECT CHAT -->
                      <div class="card border-0 mb-0">
                          <div class="card-header bg-dark border border-primary text-primary">
                                <h1 class="mb-0 h6" id="current_partner_name">... ... ... </h1>
                          </div>
                          <div class="card-body bg-dark border border-primary text-primary pb-0">
                                    <div class="row">
                                          <div class="col-3 d-none d-sm-block p-1" style="height: 350px;overflow: auto;">
                                                <div class="border border-primary text-primary rounded">
                                                    <table class="table mb-0 table-dark table-hover table-bodered border-primary text-primary">
                                                    
                                                        <?php    
                                                        $sql = "SELECT * FROM users WHERE id!='$user_id'";
                                                        $result = mysqli_query($my_conn, $sql);
                                                        $num_r = mysqli_num_rows($result);
                                                        if ($num_r>0) {
                                                            while ($row=mysqli_fetch_array($result)) {
                                                                  $first_name = $row['first_name'];  
                                                                  $user_id = $row['id'];  
                                                                  $display_pic = trim($row['display_pic']);
                                                                  if (strlen($display_pic)>0) {
                                                                      // more condition need to check if the file exist
                                                                      $folder = 'uploads/user_dp/';
                                                                      $display_pic_url = $folder.$display_pic;
                                                                      if (is_writable($display_pic_url)) {
                                                                        $valid_pic_url = $display_pic_url;
                                                                      } else {
                                                                        $valid_pic_url = $dummy_img_url;
                                                                      }
                                                                  } else {
                                                                    $valid_pic_url = $dummy_img_url;
                                                                }

                                                          echo '
                                                                  <tr id="user_'.$user_id.'" onclick="select_user('.$user_id.')" class="user_item">
                                                                      <td style="width:46px"><img src="'.$valid_pic_url.'" class="img_user" /></td>  
                                                                      <td><label class="h6">'.$first_name.'</label></td>
                                                                  </tr>
                                                                  ';
                                                            }
                                                        } 
                                                        ?>
                                                      </table>
                                                </div>
                                          </div>
                                          <div class="col-10 col-sm-9 p-1">
                                                 <form action="" method="post">
                                                        <div class="border border-primary text-primary rounded p-1" style="margin-bottom:3px; height: 301px; overflow: auto;" id="chat_board">
                                                            <img src="../assets/img/chats_dummy.jpg" style="object-fit: cover;" class="h-100 w-100 rounded" alt="">
                                                        </div> 
                                                 </form>

                                                 <div class="row">
                                                   <div class="col-10 pe-1">

                                                        <form action="" method="post" id="form_msg">
                                                              <div class="input-group">
                                                                <input type="text" disabled name="input_txt" id="input_txt" class="form-control bg-dark text-white" required>
                                                                <input type="hidden" name="partner_id" id="partner_id_msg">
                                                                <button  disabled class="btn btn-outline-primary" id="btn_send_msg" type="submit">Send</button>
                                                              </div>
                                                        </form>
                                                        
                                                        <form action="#" method="post" id="form_file" style="display: none;" enctype="multipart/form-data">
                                                        <div class="input-group">
                                                          <input type="file" disabled name="input_img" id="input_img" class="form-control bg-dark text-white">
                                                          <input type="hidden" name="partner_id" id="partner_id_file">
                                                          <button disabled type="submit" class="btn btn-outline-primary" id="btn_send_file">Send</button>
                                                        </div>
                                                      </form>
                                                   </div>

                                                   <div class="col-2 ps-0">
                                                        <span class="input-group-append" id="btn_img">
                                                          <button type="submit" class="btn btn-secondary w-100"> <span class="fa fa-image"></span> </button>
                                                        </span>

                                                        <span class="input-group-append" id="btn_txt" style="display: none;">
                                                          <button type="submit" class="btn btn-secondary w-100"> <span class="fa fa-comments"></span> </button>
                                                        </span>
                                                  </div>
                                          </div>
                                          </div>

                                    </div>
                          </div>
                          <!-- <div class="card-footer border border-primary bg-dark p-1 ">
                                
                          </div> -->
                      </div>
            </div>


          </div>
        </main>
      </div>
    </div>

    
   

       <script src="../bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script> 
       <script src="../dist/js/jquery-3.7.0.js"></script>
       <script> 


            function select_user(user_id) {
                  fetch_partner(user_id);  

                  // re-fetches the messages every 1000milliseconds = 1 sec
                const inter_val = window.setInterval(()=>{   
                    fetch_messages(user_id);    

                    if (user_id!=$('#partner_id_msg').val()) {
                      clearInterval(inter_val);
                      // console.warn('cleared');
                    }
                    // console.warn(user_id);
                  }, 1000);  
             
            }

  

            // fetches the partner information
            function fetch_partner(user_id) {
                        
                   $.ajax({
                    type: 'GET',
                    url: "fetch_partner.php",
                    data: {'user_id':user_id},
                    dataType: 'json', 
                    beforeSend: function(){   
                      $("#chat_board").html(
                      '<div class="text-center my-5"><img src="../assets/img/loading-1.gif" class="w-25 my-5" alt=""></div>');
                      $('#partner_id_msg').val(user_id);   
                      $('#partner_id_file').val(user_id);   
                   },

                    success:function(response){  
                              // console.log(response); 
                              $("#current_partner_name").html('<a href="profile.php?url_user_id='+user_id+'">'+response.first_name+' '+response.last_name+'</a>');
                    },
                    error:function(response){  
                              //  $("#chat_board").html(
                              //               '<div class="text-center my-5"><p class="my-5">something went wrong, please try again</p></div>'
                              //   );
                    },
                 });
            }


            // fetches the messages 
            function fetch_messages(user_id) { 
                   $.ajax({
                    type: 'GET',
                    url: "chat_fetch.php",
                    data: {'user_id':user_id},
                    dataType: 'text',
                    beforeSend: function(){  
                      // $("#chat_board").html(
                      // '<div class="text-center my-5"><img src="../assets/img/loading-1.gif" class="w-25 my-5" alt=""></div>');
                   },

                    success:function(response){  

                              $('#input_txt').prop('disabled', false);
                              $('#btn_send_msg').prop('disabled', false); 

                              $('#input_img').prop('disabled', false);
                              $('#btn_send_file').prop('disabled', false); 

                              $("#chat_board").html(
                                          '<div class="text-center my-5"><p class="my-5">'+response+'</p></div>'
                              );

                              // console.log(response);

                              var objDiv = document.getElementById("chat_board");
                              objDiv.scrollTop = objDiv.scrollHeight;
                            
                    },
                    error:function(response){  
                               $("#chat_board").html(
                                            '<div class="text-center my-5"><p class="my-5">something went wrong, please try again</p></div>'
                                );
                    },


                      
                 });
            }
 

            // submits and send the message to server
            $("#form_msg").on( "submit", function(event) {
               
                    $.ajax({
                      type: 'POST',
                      url: "chat_send.php",
                      data: new FormData(this),
                      dataType: 'json',
                      contentType: false,
                      cache: false,
                      processData:false,
                      beforeSend: function(){ $("#input_txt").val("") },
                      success: function(response){ //console.log(response);

                          if(response.status == 'sent'){
                            console.warn(response.message);    fetch_chat();
                            var element = document.getElementById("msg_body");
                              element.scrollTop = element.scrollHeight;
                          } else {  console.warn(response.message);  }
                      }
                  });


              // prevents the page from reloading
              event.preventDefault();
            });




            $('#btn_img').click(function() {
              $(this).hide();     $('#btn_txt').show();
              $('#form_msg').hide();     $('#form_file').show();
            });


            $('#btn_txt').click(function() {
              $(this).hide();     $('#btn_img').show();
              $('#form_msg').show();     $('#form_file').hide();
            });



            $('#form_file').on('submit', function(e) {
                e.preventDefault(); 
                $.ajax({
                        type: 'POST',
                        url: "image_send.php",
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function(){  $("#file_msg").val(null) },
                        success: function(response){  console.log(response);

                            if(response.sent == 'true'){
                              console.warn(response.data);    fetch_messages(user_id);
                              var element = document.getElementById("msg_body");
                                element.scrollTop = element.scrollHeight;
                            } else {  console.warn(response.data);  }
                        }
                    });

            });



       </script>
  

  
    </body>
</html>
