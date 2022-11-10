<?php

use Hotel\Favorite;
use Hotel\User;

// Boot application
require_once __DIR__.'/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /');

    return;
}

// If no user is logged in, return to login
if (empty (User::getCurrentUserId())) {
    header('Location: /login.php');
    
    return; 
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location: /');

    return;
}

// Set room to favorites 
$favorite = new Favorite();
// Add or remove room from favorites
$isFavorite = $_REQUEST['is_favorite'];
if (!$isFavorite){
    $favorite->addFavorite($roomId, User::getCurrentUserId());
} else {
    $favorite->removeFavorite($roomId, User::getCurrentUserId());
}

// Return to home page
header(sprintf('Location: room.php?room_id=%s', $roomId));