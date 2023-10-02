<?php  
require_once('includes/conn.php');   
require_once('header.php');

$current_user_id = $_SESSION['user_id'];
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

        .offcanvas { max-width: 70%; }
        .fl {
            text-align: center;
            margin-bottom: 0px;
            padding-right: 10px;
            color: white;
            padding-left: -6px;
        }
 
     
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
                               
                                <div class="row">
                                       <div class="col-7 pl-0">
                                           <h1 class="mb-0 h6" id="current_partner_name">... ... ... </h1> 
                                       </div>
                                      <div class="col-5 text-end">
                                        <button class="btn btn-primary py-0 position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                            My Chats

                                              <span id="msg_count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
                                        </button>
                                      </div>
                                </div>
                          </div>
                          <div class="card-body bg-dark border border-primary text-primary pb-0">
                                    <div class="row">
                                          <div class="col-3 d-none d-sm-block p-1" style="height: 350px;overflow: auto;">
                                                <div class="border border-primary text-primary rounded">
                                                    <table class="table mb-0 table-dark table-hover table-bodered border-primary text-primary">
                                                    
                                                        <?php    
                                                        $sql = "SELECT * FROM users WHERE id!='$current_user_id' ORDER BY first_name ASC";
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
                                                                  <tr id="" onclick="select_user('.$user_id.')" class="user_item">
                                                                      <td style="width:46px"><img src="'.$valid_pic_url.'" class="img_user" /></td>  
                                                                      <td><label class="h6 position-relative">'.$first_name.'
                                                                          <span class="msg_lbl_'.$user_id.' position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
                                                                      </label></td>
                                                                  </tr>
                                                                  ';
                                                            }
                                                        } 
                                                        ?>
                                                      </table>
                                                </div>
                                          </div>
                                          <div class="col-12 col-sm-9 p-1">
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










<div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title fl" id="offcanvasExampleLabel">My Chats</h5>
    <button type="button" class="border border-0 bg-dark" data-bs-dismiss="offcanvas" aria-label="Close">
    <i class="fas fa-long-arrow-alt-right" style="color: #ffffff;font-size:20px;"></i>
    </button>
  </div>
  <div class="offcanvas-body p-0"> 
              <table class="table mb-0 table-dark table-hover table-bodered border-primary text-primary" style="margin-top: 67px;border-top: 1px solid;">

                                                    <!-- <tr>
                                                         <td colspan="2" class="p-0">
                                                           
                                                         </td>
                                                    </tr> -->
                                                    <?php    
                                                    $sql = "SELECT * FROM users WHERE id!='$current_user_id' ORDER BY first_name ASC";
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
                                                              <tr onclick="select_user('.$user_id.')" class="user_item">
                                                                  <td style="width:46px"><img src="'.$valid_pic_url.'" class="img_user" /></td>  
                                                                  <td><label class="h6 position-relative">'.$first_name.'
                                                                      <span class="msg_lbl_'.$user_id.' position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
                                                                  </label></td>
                                                              </tr>
                                                              ';
                                                        }
                                                    } 
                                                    ?>
          </table>
    
  </div>
</div>



    
   

       <script src="../bootstrap-5.3.0/js/bootstrap.bundle.min.js"></script> 
       <script src="../dist/js/jquery-3.7.0.js"></script>

       <script> 

      //  window.addEventListener('load', ()=>{


                // fetch chat data every seconds
                const intV = window.setInterval(()=> {
                  fetch_chats_data();
                }, 1000);
 
                
            // Function to select a user and initiate message fetching interval
            function select_user(user_id) {
                fetch_partner(user_id);

                // Set an interval to fetch messages every 1 second
                const intervalId = window.setInterval(() => {
                    fetch_messages(user_id);

                    // Check if the selected user has changed, and clear the interval if so
                    if (user_id != $('#partner_id_msg').val()) {
                        clearInterval(intervalId);
                        console.warn('Interval cleared');
                    }
                    // console.warn(user_id);
                }, 1000);   

            }

            // Function to fetch partner information
            function fetch_partner(user_id) {
                $.ajax({
                    type: 'GET',
                    url: "fetch_partner.php",
                    data: {'user_id': user_id},
                    dataType: 'json',
                    beforeSend: function() {
                        // Display loading animation while fetching
                        $("#chat_board").html('<div class="text-center my-5"><img src="../assets/img/loading-1.gif" class="w-25 my-5" alt=""></div>');
                    },
                    success: function(response) {
                        // Display partner's name as a link
                        $('#partner_id_msg').val(user_id);
                        $('#partner_id_file').val(user_id);
                        $("#current_partner_name").html('<a href="profile.php?url_user_id=' + user_id + '">' + response.first_name + ' ' + response.last_name + '</a>');
                    },
                    error: function(response) {
                        // Handle errors if any
                    },
                });
            }


            const msgCountSpan = document.getElementById('msg_count');

            // Function to fetch partner information
            function fetch_chats_data() {
                $.ajax({
                    type: 'GET',
                    url: "fetch_chats_data.php",
                    data: {},
                    dataType: 'json',
                    beforeSend: function() {
                        // Display loading animation while fetching
                    },
                    success: function(response) { 
                        var msg_count = response.msg_count;
                        if (msg_count>0) {
                          msgCountSpan.style.visibility = 'visible';
                          msgCountSpan.innerHTML = msg_count;
                        } else {
                          msgCountSpan.style.visibility = 'hidden';
                          msgCountSpan.innerHTML = msg_count;
                        } 

                        var msg_data = response.data; 
                        var arr = Object.entries(msg_data); 

                        arr.map((msg_data)=> { 
                            var single_msg_data = msg_data[1];
                            var sender = single_msg_data[0];
                            var count  = parseInt(single_msg_data[1]);
                            
                            console.log(single_msg_data);
 
                            var user_html_arr = Array.from(document.getElementsByClassName('msg_lbl_'+sender));
                            user_html_arr.map((element)=>{
                               
                              if (count>0) {
                                element.innerHTML = count
                                element.style.visibility = 'visible'
                                // element.style.display = 'initial'
                              } else {
                                element.innerHTML = count
                                element.style.visibility = 'hidden'
                                // element.style.display = 'none'
                              } 
                            })
                        })
                    },
                    error: function(response) {
                        // Handle errors if any
                    },
                });
            }



            // Function to fetch messages
            function fetch_messages(user_id) { 
                $.ajax({
                    type: 'GET',
                    url: "chat_fetch.php",
                    data: {'user_id': user_id},
                    dataType: 'text',
                    beforeSend: function() {
                        // Perform actions before fetching
                    },
                    success: function(response) {
                        // Enable input fields and display fetched messages
                        $('#input_txt').prop('disabled', false);
                        $('#btn_send_msg').prop('disabled', false);
                        $('#input_img').prop('disabled', false);
                        $('#btn_send_file').prop('disabled', false);
                        $("#chat_board").html('<div class="text-center my-5"><p class="my-5">' + response + '</p></div>');

                        // Automatically scroll to the bottom of the chat board
                        var objDiv = document.getElementById("chat_board");
                        objDiv.scrollTop = objDiv.scrollHeight;
                    },
                    error: function(response) {
                        // Handle errors if any
                        $("#chat_board").html('<div class="text-center my-5"><p class="my-5">Something went wrong, please try again</p></div>');
                    },
                });
            }

            // Function to submit and send messages to the server
            $("#form_msg").on("submit", function(event) {
                $.ajax({
                    type: 'POST',
                    url: "chat_send.php",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#input_txt").val("");
                    },
                    success: function(response) {
                        if (response.status == 'sent') {
                            console.warn(response.message);
                            fetch_chat();
                            var element = document.getElementById("msg_body");
                            element.scrollTop = element.scrollHeight;
                        } else {
                            console.warn(response.message);
                        }
                    },
                });

                // Prevent the page from reloading
                event.preventDefault();
            });

            // Event handler for switching between text and image input
            $('#btn_img').click(function() {
                $(this).hide();
                $('#btn_txt').show();
                $('#form_msg').hide();
                $('#form_file').show();
            });

            $('#btn_txt').click(function() {
                $(this).hide();
                $('#btn_img').show();
                $('#form_msg').show();
                $('#form_file').hide();
            });

            // Event handler for file submission
            $('#form_file').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "image_send.php",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#input_img").val(null);
                    },
                    success: function(response) {
                        console.log(response);

                        if (response.sent == 'true') {
                            console.warn(response.data);
                            fetch_messages(user_id);
                            var element = document.getElementById("msg_body");
                            element.scrollTop = element.scrollHeight;
                        } else {
                            console.warn(response.data);
                        }
                    },
                });
            });







      //  }) 

        </script>
  

  
    </body>
</html>
