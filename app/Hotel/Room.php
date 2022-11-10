<?php 

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;

class Room extends BaseService
{ 
    public function get($roomId)
     {
        $parameters = [
            ':room_id' => $roomId,
       ];
       return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
   
    }
    

    // GET ALL CITIES FUNCTION
    public function getCities()
    { 
        // Get cities
        $cities = [];
        try{
            $rows = $this->fetchAll('SELECT DISTINCT city FROM room');
            foreach ($rows as $row) {
                 $cities[] = $row['city']; 
            }
        }catch (\Exception $ex) {
             throw new \Exception(sprintf('Could not find cities. Error:%s', $ex->getMessage()));
        }
        
        return $cities;
    }


     // GET COUNT OF GUESTS FUNCTION
     public function getGuests()
     { 
         // Get guests
         $guests = [];
         try{ $rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');
            foreach ($rows as $row) {
               $guests[] = $row['count_of_guests']; 
         }
        }catch (\Exception $ex) {
                 throw new \Exception(sprintf('Could not find number of guests. Error:%s', $ex->getMessage()));
            }
         return $guests;
     }
   
    // GET ALLAVAILABLE ROOMS FUNCTION
    public function search($checkInDate, $checkOutDate , $city= '', $typeId= '', $selectedMinPrice='', $selectedMaxPrice='')
    {    
        // Setup parameters
        $parameters = [
    
            ':check_in_date' => $checkInDate->format(DateTime::ATOM),
            ':check_out_date' => $checkOutDate->format(DateTime::ATOM),
            ':min_price' => $selectedMinPrice,
            ':max_price' => $selectedMaxPrice 
        ];
       
        if (!empty($city)){
            $parameters[':city'] = $city; 
            print_r($city);
        }
        if (!empty($typeId)){
            $parameters[':type_id'] = $typeId; 
            print_r($typeId);
        }

        // Build query
        $sql = 'SELECT * FROM room  WHERE ';
        if (!empty($city)) {
            $sql .= 'city = :city AND '; 
        }
        if (!empty($typeId)){
            $sql .= 'type_id = :type_id AND '; 
        }
        $sql .= 'price BETWEEN :min_price AND :max_price AND '; 
        
        $sql .='room_id NOT IN (
            SELECT room_id 
            FROM booking 
            WHERE check_in_date <= :check_out_date AND check_out_date >= :check_in_date
        )';
        
        // Get results
        $row = $this->fetchAll($sql, $parameters);
        
        
        return $row;
    }
}