<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require_once("server.php");
if(!isset($_SESSION))
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//declaring variables
$username=$_SESSION['username'];
$guest_name = "";
$phone_number= "";

if(empty($_SESSION['username'])) {
  header('location: login.php');
}
/*
There was some problem while using arrays in the form, look into it later and learn.
*/

// $address=array("appartment_number"=>" ","city"=>" ","state"=>" ","pin"=>" ");
// $indentor=array("employee_id"=>" ","indentorname"=>" ", "designation"=>" ","department"=>" ",,"phone"=>" ","email"=>" " );
// $room=array("number_people"=>" ","payment"=>" ","number_rooms"=>" ", "accomodation"=>" ", "arrival"=>" ","departure"=>" ","purpose"=>" ","veg_breakfast"=>" ","veg_lunch"=>" ","veg_dinner"=>" ","nonveg_breakfast"=>" ","nonveg_lunch"=>" ","nonveg_dinner"=>" ");

//connect to database
$dbc=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
  }



$guest_name=$_POST['guest_name'];
$phone_number=$_POST['phone_number'];
$appartment_number=$_POST['appartment'];
$city=$_POST['city'];
$state=$_POST['state'];
$pin=$_POST['pin'];
$employee_id=$_POST['employee_id'];
$indentorname=$_POST['indentorname'];
$designation=$_POST['designation'];
$department=$_POST['department'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$room_number_people=$_POST['number_people'];
$room_payment=$_POST['payment'];
$room_number_rooms=$_POST['number_rooms'];
$room_accomodation=$_POST['accomodation'];
$room_arrival=$_POST['arrival'];
$room_departure=$_POST['departure'];
$room_purpose=$_POST['purpose'];
$room_veg_breakfast=$_POST['veg_breakfast'];
$room_veg_lunch=$_POST['veg_lunch'];
$room_veg_dinner=$_POST['veg_dinner'];
$room_nonveg_breakfast=$_POST['nonveg_breakfast'];
$room_nonveg_lunch=$_POST['nonveg_lunch'];
$room_nonveg_dinner=$_POST['nonveg_dinner'];
$s='N/A';


$random_id = bin2hex(random_bytes(8));
$_SESSION['id']=$random_id;




//guest info
//guest address
//indentor info
//room
//all info is finally saved in a single table 'bookings'.


// $sql= "INSERT INTO guestinfo (id,username,guestname,guestphone) VALUES ('$random_id','$username','$guest_name','$phone_number')";
// mysqli_query($dbc,$sql);
//
// $sql= "INSERT INTO guestaddress (id,username,guestname,appartment,city,state,pin) VALUES ('$random_id','$username','$guest_name','$appartment_number','$city','$state','$pin')";
// mysqli_query($dbc,$sql);
//
// $sql= "INSERT INTO indentorinfo (id,username,guestname,employeeid,indentorname,designation,department,phone,email) VALUES ('$random_id','$username','$guest_name','$employee_id','$indentorname','$designation','$department','$phone','$email')";
// mysqli_query($dbc,$sql);
//
// $sql= "INSERT INTO roomrequirement (id,username,guestname,number_people,payment,number_rooms,accomodation,arrival,departure,purpose,vegbreakfast,veglunch,vegdinner,nonvegbreakfast,nonveglunch,nonvegdinner) VALUES ('$random_id','$username','$guest_name','$room_number_people','$room_payment','$room_number_rooms','$room_accomodation','$room_arrival','$room_departure','$room_purpose','$room_veg_breakfast','$room_veg_lunch','$room_veg_dinner','$room_nonveg_breakfast','$room_nonveg_lunch','$room_nonveg_dinner')";
// mysqli_query($dbc,$sql);

$sql= "INSERT INTO bookings (id,username,guestname,guestphone,appartment,city,state,pin,employeeid,indentorname,designation,department,phone,email,number_people,payment,number_rooms,accomodation,arrival,departure,purpose,vegbreakfast,veglunch,vegdinner,nonvegbreakfast,nonveglunch,nonvegdinner,requestedrooms) VALUES ('$random_id','$username','$guest_name','$phone_number','$appartment_number','$city','$state','$pin','$employee_id','$indentorname','$designation','$department','$phone','$email','$room_number_people','$room_payment','$room_number_rooms','$room_accomodation','$room_arrival','$room_departure','$room_purpose','$room_veg_breakfast','$room_veg_lunch','$room_veg_dinner','$room_nonveg_breakfast','$room_nonveg_lunch','$room_nonveg_dinner','$s')";
mysqli_query($dbc,$sql);

//Mailing

{
  // redirect to homepage
  $_SESSION['username']=$username;
  $_SESSION['email']=$email;
  $_SESSION['id']=$random_id;
  $_SESSION['success'] = "You are now logged in.";


  //confirmation mail block

    // Load Composer's autoloader
    require 'phpmailer/vendor/autoload.php';

        try
        {
          // Instantiation and passing `true` enables exceptions
              $mail = new PHPMailer(true);

              //Server settings
              $mail->SMTPDebug = 1;                                       // Enable verbose debug output
              $mail->isSMTP();                                            // Set mailer to use SMTP
              $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
              $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
              $mail->Username   = 'theoriginalmk7@gmail.com';                     // SMTP username
              $mail->Password   = 'uqmftsMfU9ustcw';                               // SMTP password
              $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
              $mail->Port       = 587;                                    // TCP port to connect to

              //Recipients
              $mail->setFrom('theoriginalmk7@gmail.com', 'Guesthouse IIT PATNA');
              $mail->addAddress($email);     // Add a recipient
              //$mail->addAddress('ellen@example.com');               // Name is optional
              // $mail->addReplyTo('info@example.com', 'Information');
              // $mail->addCC('cc@example.com');
              // $mail->addBCC('bcc@example.com');

              // // Attachments
              // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
              // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

              // Content
              $mail->isHTML(true);                                  // Set email format to HTML
              $mail->Subject = 'Booking request received.';
              $mail->Body    = "Hello ".$_SESSION['username'].",<br><br>Your request for booking has been registered.<br>Your booking ID is ".$_SESSION['id'].". <br>You will be suitably notified the status of your booking. <br>
              <br> Thank you";
              //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

              if($mail->send())
                  echo 'Message has been sent';
              else
                  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      finally{
        //finally block necessary
        // heading to chooseroom.php
        header('location: homepage.php');
      }
}
 ?>
