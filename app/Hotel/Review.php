<?php 

namespace Hotel;

use Hotel\BaseService;


class Review extends BaseService
{   
    public function getListByUser($userId)
    {
      $parameters = [
        ':user_id' => $userId,
      ];
      
      return $this->fetchAll('SELECT review.*, room.name
      FROM review
      INNER JOIN room ON review.room_id= room.room_id
      WHERE user_id = :user_id
      LIMIT 5', $parameters);
      //  print_r($parameters);die;
    }

    public function insert($roomId, $userId, $rate, $comment)
    {
        // Start transaction
        $this->getPdo()->beginTransaction();

        // Insert review
        $parameters = [
          ':user_id' => $userId,
          ':room_id' => $roomId,
          ':rate' => $rate,
          ':comment' => $comment
        ];
        $this->execute('INSERT INTO review (room_id, user_id, rate, comment) VALUES (:room_id , :user_id, :rate, :comment )',$parameters);
       
        // Update room average reviews
        $parameters = [
             ':room_id' => $roomId,
        ];
        $roomAverage = $this->fetch('SELECT avg(rate) as avg_reviews, count(*) as count FROM review WHERE room_id = :room_id ',$parameters);
          
        $parameters = [
            ':room_id' => $roomId,
            ':avg_reviews' => $roomAverage['avg_reviews'],
            ':count_reviews' => $roomAverage['count']
        ];
        $this->execute('UPDATE room Set avg_reviews =:avg_reviews , count_reviews = :count_reviews WHERE room_id = :room_id',$parameters);

      //    Commit transaction
       return $this->getPdo()->commit();
    }

    public function getReviewsByRoom($roomId)
    {   
        $parameters = [
            ':room_id' => $roomId,
       ];
       return $this->fetchAll('SELECT review.*, user.name as user_name 
       FROM review 
       INNER JOIN user ON review.user_id = user.user_id
       WHERE room_id = :room_id
       ORDER BY created_time ASC', $parameters);
    }

}