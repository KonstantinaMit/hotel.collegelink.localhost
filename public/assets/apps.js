// REGISTER VALIDATION
function validateformRegistration(){
  var name=document.formRegistration.name.value;
  var password=document.formRegistration.password.value;
  var email=document.formRegistration.email.value;
  var emailRepeat=document.formRegistration.email_repeat.value;
  var atposition=email.indexOf("@");
  var dotposition=email.lastIndexOf(".");

    // Name not empty and password at least 6 characters
      if (name==null || name==""){
         alert("Name can't be blank");
         return false;
         }else if(password.length<6){
         alert("Password must be at least 6 characters long.");
         return false;
         }

      //   E mail must have @ and dot
      // (at least one character before and after)
      if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){
          alert("Please enter a valid e-mail address \n atpostion:"
                 +atposition+"\n dotposition:"+dotposition);
          return false;
          }

       // Verify Emails
       if (email==emailRepeat){
             return true;
           }
             else{
             alert("E-mail addresses must be same!");
             return false;
           }
}
// LOGIN VALIDATION
function validateformLogin(){
  var password=document.formRegistration.password.value;
  var email=document.formRegistration.email.value;
  var atposition=email.indexOf("@");
  var dotposition=email.lastIndexOf(".");


    //   password at least 6 characters
         if(password.length<6){
         alert("Password must be at least 6 characters long.");
         return false;
         }

      //   E mail must have @ and .characher
      // (at least one character before and after)
      if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length){
          alert("Please enter a valid e-mail address \n atpostion:"
                 +atposition+"\n dotposition:"+dotposition);
          return false;
        }}



// SEARCH VALIDATION
function validateformSearchRoom(){
  // Not empty date city
  var check_in_date=document.formSearchRoom.check_in_date.value;
  var check_out_date=document.formSearchRoom.check_out_date.value;
  var city=document.formSearchRoom.city.value;

  if (check_in_date==null || check_in_date==""){
     alert("Check In date can't be blank");
     return false;
   }
  if (check_out_date==null || check_out_date==""){
      alert("Check Out date can't be blank");
      return false;
    }
  // Not empty city 
  if (city == null || city ==""){
    alert("City can't be blank");
    return false;
  }
}

//BOOKING VALIDATION
function validateformbookingForm(){

var check_in_date=document.formbooking.check_in_date.value;
var check_out_date=document.formbooking.check_out_date.value;
var room_id=document.formbookingForm.room_id.value;

if (check_in_date==null || check_in_date==""){
  alert("Check In date can't be blank");
  return false;
}
if (check_out_date==null || check_out_date==""){
   alert("Check Out date can't be blank");
   return false;
 }

  if (room_id == null || room_id ==""){
    alert("RoomId can't be blank");
    return false;
  }
}
// REVIEW VALIDATION
function validateformreviewForm(){

var rate=document.formreviewForm.rate.value;
var comment=document.formreviewForm.comment.value;

if (rate !== undefined && rate !== null) {
  alert("Please rate room!");
  return false;
}
if (comment==null || comment==""){
  alert("Please tell us your experience!");
  return false;
}
}
// CALENDAR +2 DATES MINIMUN SET 
$(document).ready(function(){


  $(function() {
      $("#check_in_date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0
      });
  });

  $(function() {
      $("#check_out_date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0
      });
  });

  $('#check_in_date').change(function() {
      let temp_get_date = new Date($('#check_in_date').datepicker('getDate'));
      var min_date_plus_two = new Date(temp_get_date.getFullYear(), temp_get_date.getMonth(), temp_get_date.getDate() + 3);
      $("#check_out_date").datepicker("option", "minDate",  min_date_plus_two);
  })

  $('#check_out_date').change(function() {
      endDate = $(this).datepicker('getDate');
      $("#check_in_date").datepicker("option", "maxDate", endDate);
  })
});


// ADD REVIEW STAR 
let star = document.querySelectorAll('input');
    
     for (let i = 1; i < star.length; i++) {
	   star[i].addEventListener('click', function() {
		 i = this.value;
  	 });
     }
     
// TO THE TOP BUTTON 
 //Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// LOGOUT CLEAR COOKIE BUTTON
function logout() {
  document.cookie = "user_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
