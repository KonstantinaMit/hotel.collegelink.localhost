<?php

use Hotel\User;
error_reporting(E_ALL);
ini_set('display_errors',1);

// Boot application
require_once __DIR__. '/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /');
    // var_dump('start');die;
    return;
}

// If there is already logged in user, return to main page
if (!empty (User::getCurrentUserId())) {
 
    header('Location: /');
    return;
}

// Verify user

$user= new User();

try{
    if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])){
        header('Location: /login.php?error=Could not verify user');

        return ;
    }
}catch (InvalidArgumentException $ex){
    header('Location:/login.php?error  = No user exists with this email address');

    return;
}

// Create token as cookie for user 
  $userInfo = $user->getByEmail($_REQUEST['email']);
  $token = $user->getUserToken($userInfo['user_id']);
  setcookie('user_token', $token , time() +(30 * 24 *60 *60), '/'); 
  // Return to home page
  header('Location: /index.php');