<?php

require __DIR__. '/boot/boot.php';

use Hotel\User;

// Check for existing logged in user
if (!empty (User::getCurrentUserId())) {
   header('Location: index.php'); die;
}

?>

<!doctype html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Page</title>
    <script src="public/assets/jquery/jquery-3.6.0.js"></script>
    <script src="public/assets/jquery/jquery-ui.js"></script>
    <link href="public/assets/jquery/jquery-ui.css" rel= "stylesheet"/>
    <link rel="stylesheet" type="text/css" href="public/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="public/assets/styles.css">
    <script src="public/assets/pages/search.js"></script>
    <script src="public/assets/pages/room.js"></script>
</head>
 <body>
    <header>
       <div class="container-fluid">
           <nav class="navbar navbar-expand-lg fixed-top  bg-light ">
                <div class="container">
                     <a class="navbar-brand" href="#">Hotels</a>
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                         <span class="navbar-toggler-icon"></span>
                      </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                       <ul class="navbar-nav ms-auto">
                         <li class="nav-item">
                           <a class="nav-link active" aria-current="page" href="#">
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fa fa-fw fa-home"></i> Home </a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="login.php"><i class="fa fa-fw fa-user"></i> Login </a>
                         </li>
                       </ul>
                    </div>
                </div>
           </nav>
        </div>
     </header>
    <section class="hero">
      <main>
       <div class="container">
          <div class = "row">
            <div class="col col-12 text center pt-5 mt-5">
                <form name="formRegistration" method="post" action="public/actions/register.php" onsubmit="return validateformRegistration()">
                    <?php if (!empty($_GET['error'])) { ?>
                        <div class="alert alert-danger alert-styled-left">Register Error</div>
                    <?php } ?>
                      <h3 class="home-title">
                         <span>Welcome Traveller!</span>
                         <span>Please create your account!</span>
                       </h3>
                       <br>
                      <div class = "form-group" title="name">
                          <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="floatingInput" placeholder="name" autocomplete="off">
                            <label class="my-1 d-flex align-items-center" for="floatingInput"> <i class="fa fa-fw fa-user-circle"></i> Enter your name <span class="md-auto"></span></label>
                          </div>
                        </div>
                      <div class = "form-group" title="email">
                          <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
                            <label class="my-1 d-flex align-items-center" for="floatingInput"> <i class="fa fa-fw fa-envelope"></i>Enter your Email address <span class="ml-auto"></span></label>
                          </div>
                        </div>
                      <div class = "form-group" title="email_repeat">
                           <div class="form-floating mb-3">
                             <input type="email" name="email_repeat" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="off">
                             <label class="my-1 d-flex align-items-center" for="floatingInput"> <i class="fa fa-fw fa-envelope"></i> Verify your Email address <span class="ml-auto"></span></label>
                           </div>
                        </div>
                      <div class = "form-group" title="password">
                          <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingInput" placeholder="password" autocomplete="off">
                            <label class="my-1 d-flex align-items-center" for="floatingInput"> <i class="fa fa-fw fa-lock"></i> Enter your password <span class="ml-auto"></span></label>
                          </div>
                        </div>
                        <br>
                      <div class="col align-self-center" >
                        <div class = "form-group">
                         <div class="action-Form_register_login" title="Register">
                            <input type="hidden" name="csrf" value= "<?php echo User::getCsrf(); ?>">
                            <input type="submit" value="Register" class="btn bn53"></button>
                         </div>
                        </div>
                      </div>
                      <p class="text-center">Have already an account? <a href="login.php">Log In</a> </p>
                </form>
            </div>
          </div>
       </div>
      </main>
    </section>
    <footer>
      <div class="container-fluid">
        <p> © Konstantina Mitropoulou Project 2022 </p>
      </div>
     </footer>
    <link rel="stylesheet"  href="public/assets/css/fontawesome.min.css">
    <script src="public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/apps.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  </body>
 </html>
