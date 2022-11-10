<?php 

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;

class RoomType extends BaseService
{ 
    // GET ALL TYPES OF ROOMS FUNCTION
    public function getAllTypes()
    { 
        return $this->fetchAll('SELECT * FROM room_type');
    }
    
}
