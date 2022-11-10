<?php

require __DIR__. '/boot/boot.php';

use Hotel\Room;
use DateTime as DateTime;
use Hotel\RoomType;

// Initialize Room service
$room = new Room();
$type = new RoomType();

// Get all cities
$cities = $room->getCities();
// Get room types
$allTypes = $type->getAllTypes();

// Get count of guests
$countOfGuests = $room ->getGuests();

// Get page parameters
$selectedcountOfGuests = $_REQUEST['count_of_guests'];
$selectedCity = $_REQUEST['city'];
$selectedTypeId = $_REQUEST['room_type'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$selectedMinPrice = $_REQUEST['min_price'] ?: 0;
$selectedMaxPrice = $_REQUEST['max_price']  ?: PHP_INT_MAX;



// Search for Room
$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId, $selectedMinPrice, $selectedMaxPrice);
?>

<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>List Rooms Page </title>
   <script src="public/assets/jquery/jquery-3.6.0.js"></script>
   <script src="public/assets/jquery/jquery-ui.js"></script>
   <link href="public/assets/jquery/jquery-ui.css" rel= "stylesheet"/>
   <link rel="stylesheet" type="text/css" href="public/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="public/assets/styles.css">
   <script src="public/assets/pages/search.js"></script>
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
     <div class="container">
       <div class= "row">
           <div class = "col-md-4 sticky-sidebar box with-border-image">
             <form name="formSearchRoom" class="searchForm" action="list.php" onsubmit="return validateformSearchRoom()">
                   <h5 class ="home-title top text-uppercase">
                       <span>Find the perfect Hotel</span>
                      </h5>
                   <div class = "form-group" title="Guests">
                        <select id="count_of_guests" name="guests" class="custom-select" data-placeholder="Count of guests">
                         <option value="" selected hidden>Count of guests</option>
                         <?php
                                foreach ($countOfGuests as $count_of_guests) {
                              ?>
                              <option <?php echo $selectedcountOfGuests == $count_of_guests['type_id'] ? 'selected="selected"' : ''; ?>value ="<?php echo $count_of_guests['type_id']; ?>"><?php echo $count_of_guests['title'] ; ?></option>
                               <?php
                                  }
                              ?>
                        </select>
                    </div>
                    <div class = "form-group" title="Room Type">
                         <select id="room_type" name="room_type" class="custom-select" data-placeholder="Room Type">
                         <option value="" selected hidden>Room Type</option>
                         <?php
                                foreach ($allTypes as $roomType) {
                              ?>
                                <option <?php echo $selectedTypeId == $roomType['type_id'] ? 'selected="selected"' : ''; ?>value ="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title'] ; ?></option>

                              <?php
                                  }
                              ?>
                         </select>
                     </div>
                   <div class = "form-group" title="City">
                        <select id="city" name="city" class="custom-select" data-placeholder="City">
                        <option value="" selected hidden>City</option>
                             <?php
                                foreach ($cities as $city) {
                              ?>
                                <option <?php echo $selectedCity == $city ? 'selected="selected"' : ''; ?> value ="<?php echo $city; ?>"><?php echo $city; ?></option>
                              <?php
                                  }
                              ?>
                        </select>
                    </div>
                   <div class = "form-group" title="Price ranger">
                    <p>
                     <label for="amount">Select Price:</label>
                     <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                     <input type="hidden" name="min_price" id="range-min-price" value="0">
                     <input type="hidden" name="max_price" id="range-max-price" value="500">
                    </p> 
                   <div id="slider-range"></div>
                   </div>
                   <div class="form-group" title="Check In Dates">
                   <input type="text" id="check_in_date" class="form-control" name="check_in_date" value="<?php echo $checkInDate; ?>"placeholder="Check Out Dates">
                  </div>
                   <div class="form-group" title="Check Out Dates">
                              <input type="text" id="check_out_date" class="form-control" name="check_out_date" value="<?php echo $checkOutDate; ?>"placeholder="Check Out Dates">
                      </div>
                   <div class="form-group" title="Button">
                      <button type="submit" class="btn btn-sm form-control" style="text-transform:uppercase;">Find hotel </button>
                    </div>
            </form>
           </div>
           <div class ="col-md-8 main" id="search-results-container">
             <div class ="title text-center">
                 <h5>Search Results</h5>
              </div>
               <br>
            <?php
                 foreach ($allAvailableRooms as $availableRoom) {
            ?>
            <section class="thumbnail_room">
               <div class="row">
                 <div class="col-sm-3" title="Image Room">
                   <div class="media">
                      <img src="public/assets/images/rooms/<?php echo $availableRoom['photo_url'];?>" class="img-thumbnail" alt=""/>
                      <div class="overlay">
                        <a target="_blank" href= public/assets/images/rooms/<?php echo $availableRoom['photo_url'];?> class="icon" title="Open Image">
                           <i class="fa fa-fw fa-camera"></i>
                         </a>
                        </div>
                   </div>
                 </div>
                 <div class="col-sm-9" title="Room Info">
                    <div class="small_descreption">
                       <h5 class="effect-title"><?php echo $availableRoom['name'];?></h5>
                       <br>
                       <small> <?php echo $availableRoom['city'];?> , <?php echo $availableRoom['area'];?></small>
                       <br>
                       <p><?php echo $availableRoom['description_short'];?></p>
                       <br>
                       <div class="clear"></div>
                       <div class="text-right">
                       <a href="room.php?room_id=<?php echo $availableRoom['room_id'];?>&check_in_date=<?php echo $checkInDate;?>&check_out_date=<?php echo $checkOutDate;?>"
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
                         <p>Per Night:<?php echo $availableRoom['price'];?>€</p>
                        </div>
                     </div>
                     <div class="col-sm-9">
                       <div class="row">
                         <div class="col-6 col-sm-6">
                           <div class="count">
                             <p>Count Of Guests:<?php echo $availableRoom['count_of_guests'];?></p>
                          </div>
                         </div>
                         <div class="col-6 col-sm-6">
                           <div class="room">
                             <p>Type of Room:<?php echo $availableRoom['type_id'];?></p>
                          </div>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
              </div>
            <hr>
            </section>
            <?php
               }
            ?>
            <br>
            <?php
               if (count($allAvailableRooms) == 0) {
            ?>
              <h2 class= "check-search text-center"> There are no rooms !!!</h2>
              <hr>
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
     <!-- RANGER PRICE  -->
     <script>
     $(function() {
         var minPriceInEuro = 0;
         var maxPriceInEuro = 500;
         var currentMinValue = 0;
         var currentMaxValue = 500;
    
         $( "#slider-range" ).slider({
        range: true,
        min: minPriceInEuro,
        max: maxPriceInEuro,
        values: [ currentMinValue, currentMaxValue ],
        slide: function( event, ui ) {
            $( "#amount" ).val( "€" + ui.values[ 0 ] + " - €" + ui.values[ 1 ] );
            currentMinValue = ui.values[ 0 ];
            currentMaxValue = ui.values[ 1 ];
        },
        stop: function( event, ui ) {
            currentMinValue = ui.values[ 0 ];
            currentMaxValue = ui.values[ 1 ];
            document.getElementById("range-min-price").value = currentMinValue;
            document.getElementById("range-max-price").value = currentMaxValue;
        }
         });

        $( "#amount" ).val( "€" + $( "#slider-range" ).slider( "values", 0 ) +
        " - €" + $( "#slider-range" ).slider( "values", 1 ) );
      });
    </script>
    <link rel="stylesheet"  href="public/assets/css/fontawesome.min.css">
    <script src="public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/apps.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  </body>
 </html>
