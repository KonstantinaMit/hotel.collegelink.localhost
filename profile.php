<?php 

require __DIR__. '/boot/boot.php';


use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;

// Check for logged in user
$userId = User::getCurrentUserId();
if(empty($userId)) {
  header('Location: login.php');
  return;
}

// Get all favorites
$favorite = new Favorite();
$userFavorites = $favorite ->getListByUser($userId);

// Get all reviews
$review = new Review();
$userReviews = $review->getListByUser($userId);


// Get all user bookings
$booking= new Booking();
$userBookings = $booking->getListByUser($userId);



?>

<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Profile Page </title>
   <script src="public/assets/jquery/jquery-3.6.0.js"></script>
   <script src="public/assets/jquery/jquery-ui.js"></script>
   <link href="public/assets/jquery/jquery-ui.css" rel= "stylesheet"/>
   <link rel="stylesheet" type="text/css" href="public/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="public/assets/styles.css">
   <script src="public/assets/pages/search.js"></script>
   <script src="public/assets/pages/room.js"></script>
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
                            <a class="nav-link" href="login.php" onclick="logout()"><i class="fa fa-fw fa-user"></i> Logout 
                          </a>
                         </li>
                       </ul>
                    </div>
                </div>
           </nav>
        </div>
    </header>
    <button
        type="button"
        class="btn btn-danger btn-floating btn-lg"
        id="btn-back-to-top" >
        <i class="fas fa-arrow-up"></i>
    </button>
     <div class="container">
       <div class= "row">
           <div class = "col-md-4 sticky-sidebar box with-border-image">
             <div class="profile-title top text-uppercase">
             <h5>Favorites</h5>
             </div>
             <div class="row">
               <div class="col-sm">
                 <div class="form-group">
                  <?php 
                      if (count($userFavorites) >0){
                   ?>
                   <ol>
                      <?php  
                         foreach ($userFavorites as $favorite) {
                      ?>
                     <li> 
                       <a href="room.php?room_id= <?php echo $favorite['room_id']; ?>"> <?php echo $favorite['name']; ?> </a>
                    </li>
                    <?php 
                         }
                    ?>
                    </ol>
                    <?php 
                        } else {
                    ?>
                       <h5>You don't have any favorite hotel !</h5>
                    <?php
                      }
                    ?>
                  </div>
               </div>
             </div>
             <div class="row">
                 <div class="col-sm">
                   <div class="profile-title text-uppercase">
                     <h5>Reviews</h5>
                     </div>
                   <div class="form-group">
                      <?php 
                         if (count($userReviews) >0){
                        ?>
                     <ol>
                      <?php  
                         foreach ($userReviews as $review) {
                        ?>
                       <li><a href="room.php?room_id=<?php echo $review['room_id']; ?>"> <?php echo $review['name']; ?> </a></li>
                         <div class="reviewed-rooms">
                         <?php 
                              for ($i = 1; $i <=5; $i++){
                                 if ($review ['rate'] >=$i){
                                     ?>
                                     <span class="fa fa-fw fa-star checked"></span>
                                     <?php
                                 } else {
                                     ?>
                                    <span class="fa fa-fw fa-star"></span>
                                    <?php
                                }
                             }
                           ?> 
                         </div>
                         <?php 
                             }
                         ?>
                         </ol>
                      <?php 
                        } else {
                       ?>
                       <h5>You don't have any review yet !</h5>
                      <?php
                          }
                       ?>
                    </div>
                 </div>
             </div>
           </div>
           <div class ="col-md-8 main ">
             <div class="title text-center">
                 <h3>My Bookings</h3>
             </div>
            <br>
            <?php 
               if (count($userBookings) >0){
            ?>
            <?php  
                foreach ($userBookings as $booking) {
             ?>      
            <section class="thumbnail_room">
               <div class="row">
                  <div class="col-sm-3" title="Image Room">
                   <div class="media">
                      <img src="public/assets/images/rooms/<?php echo $booking['photo_url'];?>" class="img-thumbnail" alt="Hilton Hotel "/>
                      <div class="overlay">
                        <a target="_blank" href=public/assets/images/rooms/<?php echo $booking['photo_url'];?> class="icon" title="Open Image">
                           <i class="fa fa-fw fa-camera"></i>
                         </a>
                        </div>
                   </div>
                   </div>
                  <div class="col-sm-9" title="Room Info">
                    <div class="small_descreption">
                       <h6  class="effect-title"><?php echo $booking['name'];?></h6>
                       <br>
                       <small> <?php echo sprintf('%s, %s', $booking['city'] ,$booking['area']);?></small>
                       <br>
                       <p><?php echo $booking['description_short'];?></p>
                       <br>
                       <div class="clear"></div>
                       <div class="text-right">
                       <a href="room.php?room_id=<?php echo $booking['room_id'];?>&check_in_date=<?php echo $booking['check_in_date'];?>&check_out_date=<?php echo $booking['check_out_date'];?>"
                       class="btn btn-sm">Go to the room page </a>
                      </div>
                    </div>
                    <div class="clear"></div>
                    <br>
                    </div>
                  <div class="container text-center">
                    <div class="row">
                     <div class="col-sm-3">
                       <div class="cost">
                         <p>Total cost:<?php echo $booking['total_price']; ?>€</p>
                        </div>
                     </div>
                     <div class="col-sm-9">
                       <div class="row">
                         <div class="col-4 col-sm-4">
                           <div class="check-in">
                             <p>Check in Dates:<?php echo $booking['check_in_date']; ?></p>
                          </div>
                         </div>
                         <div class="col-4 col-sm-4">
                           <div class="check-out">
                             <p>Check out Dates:<?php echo $booking['check_out_date']; ?></p>
                          </div>
                         </div>
                         <div class="col-4 col-sm-4">
                           <div class="room">
                             <p>Type of Room: <?php echo $booking['type_id'];?></p>
                          </div>
                         </div>
                       </div>
                     </div>
                    </div>
                  </div>
                  <hr>
               </div>
               <?php 
                  }
                ?>
              </section>
        
            <?php 
               } else {
            ?>
            <h4>You don't have any bookings!</h4>
            <?php
              }
            ?>
          </div>
      </div>
     </div>
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
