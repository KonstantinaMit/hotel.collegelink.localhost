<?php

use Hotel\Favorite;
use Hotel\User;

// Boot application
require_once __DIR__.'/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    echo "This is a post script.";
    die;

}

// If no user is logged in, return to main page
if (empty (User::getCurrentUserId())) {
    echo "No current user for this operation.";
    die;
   
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    echo "No room is given for this operation.";
    die;
}

// Set room to favorites 
$favorite = new Favorite();

// Add or remove room from favorites
$isFavorite = $_REQUEST['is_favorite'];
if (!$isFavorite){
    $status = $favorite->addFavorite ($roomId, User::getCurrentUserId());
} else {
    $status = $favorite->removeFavorite ($roomId, User::getCurrentUserId());
}

// Return operation status
header('Content-Type:application/json');
echo json_encode([
    'status'=> $status,
    'is_favorite'=> !$isFavorite,
]); 