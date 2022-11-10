<?php

require __DIR__. '/../../boot/boot.php';

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
$selectedMinPrice = $_REQUEST['min_price'] ?: 0;;
$selectedMaxPrice = $_REQUEST['max_price']  ?: PHP_INT_MAX;

// Search for Room
$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId, $selectedMinPrice, $selectedMaxPrice);
?>


             <div class ="title text-center">
                 <h5>Search Results </h5>
              </div>
               <br>
            <?php
                 foreach ($allAvailableRooms as $availableRoom) {
            ?>
            <section class="thumbnail_room">
               <div class="row">
                 <div class="col-sm-3" title="Image Room">
                   <div class="media">
                      <img src="public/assets/images/rooms/<?php echo $availableRoom['photo_url'];?>" class="img-thumbnail" alt="Hilton Hotel "/>
                      <div class="overlay">
                        <a target="_blank" href= public/assets/images/rooms/<?php echo $availableRoom['photo_url'];?>  class="icon" title="Open Image">
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