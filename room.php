<?php 

require __DIR__. '/boot/boot.php';

// header ('Access-Control-Allow-Origin: https://www.collegelink.gr');

use Hotel\Room;
use Hotel\Favorite;
use Hotel\User;
use Hotel\Review;
use Hotel\Booking;


// Initialize Room service
$room = new Room();
$favorite = new Favorite();

// Check for room id
$roomId = $_REQUEST['room_id'];
if (empty ($roomId)) {
    header('Location: index.php');
    return;
}

// Load room info
$roomInfo = $room ->get($roomId);
if (empty ($roomInfo)) {
    header('Location: index.php');
    return;
}

// Get current user id 
$userId = User::getCurrentUserId();
// var_dump($userId);


// Check if room is favorite for current user
$isFavorite =$favorite->isFavorite($roomId, $userId);
// var_dump($isFavorite);die;

// Load all room reviews
$review = new Review();
$allReviews = $review->getReviewsByRoom($roomId);
// print_r($allReviews);



// Check for booking room
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$alreadyBooked= empty($checkInDate) || empty($checkOutDate);
if (!$alreadyBooked) {
  //  Look for bookings
  $booking = new Booking();
  $alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
  // var_dump($alreadyBooked); 
}
?>

<!doctype html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Room Page </title>
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
                     <a class="navbar-brand" href="index.php">Hotels</a>
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
                            <a class="nav-link" href="profile.php"><i class="fa fa-fw fa-user"></i> Profile </a>
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
    <section class ="main-room">
    <!-- Main Section of room page -->
     <div class="container text-center">
        <div class="info">
             <div class="row align-items-center">
                <!-- Room name, address, area  -->
                <div class="col-3">
                 <p>
                  <?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?> 
                 </p>
                </div>
                <!-- Review of room , favorite , price per night-->
                <div class="col-9">
                 <div class="row">
                    <div class="col-4">
                       <div class="reviews-room align-items-center">
                           Reviews: 
                           <?php 
                              $roomAvgReview = $roomInfo ['avg_reviews'];
                              for ($i = 1; $i <=5; $i++){
                                   if ($roomAvgReview >=$i){
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
                    </div>
                   <div class="col-4" id="favorite">
                     <form name="favoriteForm" class="favoriteForm"  id="favoriteForm" method="post" action="actions/favorite.php">
                        <input type ="hidden" name ="room_id" value="<?php echo $roomId; ?>">
                        <input type ="hidden" name ="is_favorite" value="<?php echo $isFavorite ? '1':'0'; ?>">
                        <input type="hidden" name="csrf" value= "<?php echo User::getCsrf(); ?>">
                        <button type="submit" id="room-heart" class="my-heart-btn <?php echo $isFavorite ? 'fa-solid':'fa-regular'; ?> fa-heart"></button>
                     </form>  
                  </div>
                   <div class="col-4">
                    <div class="cost-room">
                      <p>Per Night:<?php echo $roomInfo['price']?> €</p>
                    </div>
                  </div> 
                 </div>
               </div>
             </div>     
          </div>
        </div>
       <!-- Room images  -->
    <div class="container image-container">
       <img src="public/assets/images/rooms/<?php echo $roomInfo['photo_url'];?>" class="img-fluid" alt="room image" width="auto" height="400">
       </div>
    <!-- Room costs per night,room type, parking, wifi,pet firendly section -->
    <div class="container text-center align-items-center">
          <div class="info">
            <div class="row">
              <!-- guests  -->
              <div class="col extra">
                <i id=icon class="fa fa-fw fa-user"></i>
                <span id="text"><?php echo $roomInfo['count_of_guests'];?></span>
                <p>Count Of Guests</p>
              </div>
              <!-- type of room -->
              <div class="col extra">
                <i class="fa fa-fw fa-bed"></i>
                <span id="text"> <?php echo $roomInfo['type_id'];?></span>
                <p>Type of Room</p>
              </div>
              <!-- parking -->
              <div class="col extra">
                <i class="fa fa-fw fa-car"></i>
                <span id="text"><?php echo $roomInfo['parking'];?></span>
                <p>Parking</p>
              </div>
              <!-- wifi  -->
              <div class="col extra">
                <i class="fa fa-fw fa-wifi"></i>
                <span id="text"><?php echo $roomInfo['wifi'];?></span>
                <p>wifi</p>
              </div>  
              <!-- pet friendly -->
              <div class="col extra">
                <i class="fa fa-fw fa-paw"></i>
                <span id="text"><?php echo $roomInfo['pet_friendly'];?></span>
                <p>Pet friendly</p>
              </div>
            </div>
          </div>
    </div>
    <!-- Description of room  -->
    <div class="container">
           <div class="room-description">
             <h3>Room Description</h3>
             <p><?php echo $roomInfo['description_long'];?>
              </p>
              <div class="clear"></div>
              <div class="text-right">
                <?php 
                    if ($alreadyBooked) {
                 ?>
                       <span class= "btn disabled">Already Booked</span>
                       <br>
                       <br>
                 <?php 
                    } else {
                 ?>
                    <form name ="bookingForm" method="post" action="public/actions/book.php" onsubmit="return validateformbookingForm()" validate>
                        <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                        <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>">
                        <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>">
                        <input type="hidden" name="csrf" value= "<?php echo User::getCsrf(); ?>">
                        <button class="btn" type="submit">Book Now</button>
                    </form> 
                <?php 
                    }
                ?>
              </div>
           </div>
    </div>
    <!-- Map view of room location -->
    <div class="container map-container">
     <div id="map"></div>
       </div>
       <hr>
    <!-- Reviews of room  -->
    <div class="container">
      <div class="room-reviews">
        <h3>Reviews</h3>
        <div class="room-reviews-container">    
           <?php 
              foreach ($allReviews as $counter => $review){
            ?> 
           <h4>
              <span><?php echo sprintf('%d. %s', $counter +1, $review ['user_name']) ; ?></span>
              <div class="div-reviews">
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
           </h4>
           <h6>Created at:<?php echo $review ['created_time'] ; ?> </h6>
           <p><?php echo htmlentities($review ['comment']) ; ?> </p>
      <?php 
              }
      ?>
       </div>
    </div>
         <!-- Add review -->
        <div class="add-review">
         <h3>Add Review</h3>
          <form name= "reviewForm" class="reviewForm" method="post" action="public/actions/review.php" onsubmit="return validateformreviewForm()" validate >
            <input type="hidden" name="room_id" value= "<?php echo $roomId ?>" required>
            <input type="hidden" name="csrf" value= "<?php echo User::getCsrf(); ?>" required>
            <div class="rating-wrap" >
				       <fieldset class="rating" >
				      	 <input type="radio" id="star5" required name="rate" value="5"/><label for="star5" class="full" title="Awesome"></label>
				      	 <input type="radio" id="star4" required name="rate" value="4"/><label for="star4" class="full" title="Pretty good"></label>
				      	 <input type="radio" id="star3" required name="rate" value="3"/><label for="star3" class="full" title="Meh"></label>
				      	 <input type="radio" id="star2" required name="rate" value="2"/><label for="star2" class="full" title="Kinda Bad  "></label>
					       <input type="radio" id="star1" required name="rate" value="1"/><label for="star1" class="full" title="Sucks"></label>
               </fieldset>
               <textarea id="reviewField" name="comment" placeholder="Reviews"required></textarea>
               <button type="submit" class="btn " value="Submit">Submit</button>
		        </div>
        </form>
       </div>
  

       <!-- End of Main Section of room page -->
            </section>        
    <footer>
      <div class="container-fluid">
        <p> © Konstantina Mitropoulou Project 2022 </p>
      </div>
    </footer>
    <script>
      // MAP PRESENTATION ON ROOM PAGE
     // Initialize and add the map
      function initMap() {
      // The location of room
       const myLatLng = {
          lat:<?php echo $roomInfo['location_lat'] ;?>,
          lng:<?php echo $roomInfo['location_long'] ;?>
        };
        // The map, centered 
       const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 18,
        center: myLatLng
        });
       // The marker, positioned at room
       const marker = new google.maps.Marker({
       position: myLatLng,
       map: map
       });
      }
 </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaJWtuiXXNcZGL1Vcl7z_cqS5B-vAq9H0&callback=initMap" async defer></script>
    <link rel="stylesheet"  href="public/assets/css/fontawesome.min.css">
    <script src="public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/apps.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 </html>