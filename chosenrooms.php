<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

require_once('server.php');
if(empty($_SESSION['username'])) {
  header('location: login.php');
}

$id=$_SESSION['id'];

if (isset($_POST['roomschosen'])){
  if(!empty($_POST['check_list'])){
  // Loop to store and display values of individual checked checkbox.

  foreach($_POST['check_list'] as $selected){
    if(!isset($s))
    $s=$selected;
    else {
    $s=$s.", ".$selected;
    }
  }
  $dbc= mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $update_status_query = "UPDATE bookings SET requestedrooms='$s' WHERE id='$id'";
  $update_status = mysqli_query($dbc, $update_status_query);

  $query = "SELECT requestedrooms,guestname,username,indentorname,arrival,departure,email FROM bookings WHERE id='$id'";
  $data1 = mysqli_query($dbc, $query);
  $arr1=mysqli_fetch_array($data1);
  $roomarr= explode(', ', $arr1['requestedrooms']);
  $username=$arr1['username'];
  $guestname=$arr1['guestname'];
  $indentorname=$arr1['indentorname'];
  $arrival=$arr1['arrival'];
  $departure=$arr1['departure'];
  $email = $arr1['email'];

  foreach ($roomarr as  $room) {

  $query = "SELECT type,floor FROM rooms WHERE room='$room'";
  $data2 = mysqli_query($dbc, $query);
  $arr2=mysqli_fetch_array($data2);

    $type=$arr2['type'];
    $floor=$arr2['floor'];

  $query = "INSERT INTO bookedrooms (room, type, floor, id, username, guestname, indentorname, arrival, departure) VALUES ('$room','$type', '$floor', '$id', '$username', '$guestname', '$indentorname', '$arrival', '$departure')";
  $update_status=mysqli_query($dbc, $query);

}
}

//confirmation mail block
  // Load Composer's autoloader
  require 'phpmailer/vendor/autoload.php';

  try
    {
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      //Server settings
      $mail->SMTPDebug = 0;                                       // Enable verbose debug output
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
      $mail->Subject = 'Booking request accepted.';
      $mail->Body    = "Hi ".$username.",<br><br>Welcome to the Guest House booking portal of IIT Patna. <br> Your request has been accepted.<br> <br> Thank you";
      //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      if($mail->send());
      else
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    finally {
      // finally block necessary
      header("location: admin/viewrequests.php?tab=1");
    }


}

?>
