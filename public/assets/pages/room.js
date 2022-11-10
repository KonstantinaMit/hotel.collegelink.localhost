(function ($) {
    $(document).on('submit' , 'form.favoriteForm', function(e) {
        // Stop default form behavior
        e.preventDefault();
        

        // Get form data 
        const formData = $(this).serialize();
        
        // Ajax request
        $.ajax(
            'http://hotel.collegelink.localhost/public/ajax/room_favorite.php',
            {
                 type:"POST",
                 dataType:"json",
                 data: formData
            }).done(function(result) {
                if (result.status){
                    $('input[name=is_favorite]').val(result.is_favorite ? 1 : 0);
                    if(result.is_favorite) {
                        $('#room-heart').removeClass("fa-regular").addClass("fa-solid");
                    } else {
                        $('#room-heart').removeClass("fa-solid").addClass("fa-regular");
                    }
                }
                

               
            });
        
    });

    $(document).on ('submit' , 'form.reviewForm', function(e) {
        // Stop default form behavior
        e.preventDefault();
        

        // Get form data 
        const formData = $(this).serialize();
        
        // Ajax request
        $.ajax(
            'http://hotel.collegelink.localhost/public/ajax/room_review.php',
            {
                 type:"POST",
                 dataType:"html",
                 data: formData
            }).done(function(result) {
                  
                // Append review to list
                 $('#room-reviews-container').append (result);

                // Reset review form
                $('form.reviewForm').trigger('reset');

            });
        
    });
})(jQuery);


// $('form.reviewForm input, from.reviewForm textarea,from.reviewForm button').attr('disabled' , true;)