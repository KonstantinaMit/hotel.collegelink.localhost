<?php 

namespace Hotel;

use Hotel\BaseService;
use PDO;


class User extends BaseService
{  
    const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklfsadf';

    private static $currentUserId;

    // GET EMAIL USER FUNCTION
    public function getByEmail($email)
    {   
        $parameters = [
             ':email' => $email,
        ];
        return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
    }
    // GET ID USER FUNCTION
    public function getByUserId($userId)
    {   
        $parameters = [
             ':user_id' => $userId,
        ];
        return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
    }
    // GET LIST OF USERS FUNCTION
    public function getList()
    {   
        return $this->fetchAll ('SELECT * FROM user');
       
    }

    // INSERT NEW USER-REGISTER FUNCTION
    public function insert($name, $email, $password)
    {
      // Hash password
      $passwordHash = password_hash($password, PASSWORD_BCRYPT);
     
      // prepare parameters
      $parameters = [
        ':name' => $name,
        ':email' => $email,
        ':password' => $passwordHash,
      ];
      $rows= $this->execute('INSERT INTO user (name, email, password) VALUES (:name , :email , :password)',$parameters);

      return $rows == 1;
    }
    // VERIFY USER-LOGIN FUNCTION
    public function verify($email, $password)
    {
    //   Step 1 - Retrieve User 
    $user = $this->getByEmail($email);
 
    // Ster 2- Verify user password
    return password_verify($password, $user['password']);

    }

    public function getUserToken($userId, $csrf = '')
    {
            // Create token payload
            $payload = [
                'user_id' => $userId,
                'csrf' => $csrf ?: md5(time()),
            ];
            $payloadEncoded = base64_encode(json_encode($payload));
            $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);
        
            return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public function getTokenPayload($token)
    {
    // Get payload and signature
    [$payloadEncoded] = explode('.', $token);

    // Get payload
    return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token)
    {
    // Get payload
    $payload = $this->getTokenPayload($token);
    $userId = $payload['user_id'];
    $csrf = $payload['csrf'];

    // Generate signature and verify
    return $this->getUserToken($userId, $csrf) == $token;
    }

    public static function verifyCsrf($csrf)
    {
        return self::getCsrf() == $csrf;
    }

    public static function getCsrf()
    {
        // Get token payload
        $token = $_COOKIE['user_token'];
        $payload = self::getTokenPayload($token);
     
        return $payload['csrf'];
    }

    public static function getCurrentUserId()
    {
        return self::$currentUserId;
    }
    
    public static function setCurrentUserId($userId)
    {
        self::$currentUserId = $userId;
    }

}