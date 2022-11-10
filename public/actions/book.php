<?php

use Hotel\Booking;
use Hotel\User;

// Boot application
require_once __DIR__.'/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /');

    return;
}

// If no user is logged in, return to register
if (empty (User::getCurrentUserId())) {
    header('Location: /login.php');
    
    return; 
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location:/');

    return;
}

// Create booking
$booking= new Booking();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$booking->insert($roomId ,User::getCurrentUserId(),$checkInDate, $checkOutDate);


// Return to home page 
header(sprintf('Location: /room.php?room_id=%s',$roomId));