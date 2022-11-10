<?php

require __DIR__. '/boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
use Hotel\User;


// Get cities
$room = new Room();
$cities = $room->getCities();

// Get room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

?>

<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Search Room Page</title>
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
                            <a class="nav-link" href="index.php"><i class="fa fa-fw fa-house"></i> Home </a>
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
             <form name="formSearchRoom" action="list.php" onsubmit="return validateformSearchRoom()" validate>
                   <div class="row">
                     <h3 class="home-title">
                        <span>Traveller choose your Destination!</span>
                      </h3>
                     </div>
                     <br>
                     <div class="row">
                       <div class="col-sm">
                          <div class = "form-group_home" title="city">
                          <select id="city" name="city" class="form-select" required>
                           <option value="" selected hidden>City</option>
                             <?php
                                foreach ($cities as $city) {
                              ?>
                                <option value ="<?php echo $city; ?>"><?php echo $city; ?></option>
                              <?php
                                  }
                              ?>
                          </select>
                          </div>
                       </div>
                       <div class="col-sm" >
                          <div class = "form-group_home" title="Room">
                          <select id="room_type" name="room_type" class="form-select">
                          <option value="" selected hidden>Room Type</option>
                             <?php
                                foreach ($allTypes as $roomType) {
                              ?>
                                <option value ="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title'] ; ?></option>
                              <?php
                                  }
                              ?>
                            </select>
                          </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-sm ">
                         <div class = "form-group_home" title="Calendar" required>
                         <input type="text" id="check_in_date" name="check_in_date" class="form-control" placeholder="Check In Dates" autocomplete="off">
                         </div>
                      </div>
                      <div class="col-sm">
                         <div class = "form-group_home" title="Calendar" required>
                           <input type="text" id="check_out_date" name="check_out_date" class="form-control" placeholder="Check Out Dates" autocomplete="off">
                         </div>
                     </div>
                   </div>
                   <br>
                   <div class="col" >
                    <div class = "form-group">
                      <div class="action-Form_register_login" title="Search">
                        <input type="submit" value="Search" class="btn bn53"></input>
                        <input type="hidden" name="csrf" value= "<?php echo User::getCsrf(); ?>">
                      </div>
                    </div>
                   </div>
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
