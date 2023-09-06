<header class="">
 
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark border border-primary rounded text-primary mt-2">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">FproChat</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"  
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php
                $usr_type = $_SESSION['usr_type'];
                if ($usr_type==='admin') {
                   echo ' <li class="nav-item">
                         <a href="admin_board.php" class="nav-link">Admin Board</a>
                    </li>';
                }
          ?> 
           

            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                My Account
              </a>
              <ul class="dropdown-menu pb-0">
                <li><a class="dropdown-item" href="profile.php"><?=$_SESSION['first_name']?></a></li>
                <li><hr class="dropdown-divider"></li>
                <li class=""><a class="dropdown-item p-2" href="#">
                      <form class="d-flex" action="" method="POST">
                        <button class="btn btn-danger w-100" type="submit"  name="btn_signout">Sign out</button>
                    </form>
                </a></li>
              
               <!--   <li><a class="dropdown-item" href="#">Something else here</a></li> -->
              </ul>
            </li>
           
          </ul>
     
        </div>
      </div>
    </nav>
</header>