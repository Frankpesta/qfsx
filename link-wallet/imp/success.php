<?php
session_start();

// Check if the submission was successful
if (!isset($_SESSION['submission_success']) || $_SESSION['submission_success'] !== true) {
    // Redirect back to the form if accessed directly
    header("Location: https://dashboard.wbridgeadvisors.com/user/dashboard");
    exit();
}

// Clear the session variable
unset($_SESSION['submission_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white shadow-2xl rounded-xl p-10 text-center">
        <svg class="mx-auto h-20 w-20 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
            Connection Successful
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Thank you! Your wallet has been connected successfully.
        </p>
        <div id="countdown" class="mt-4 text-lg font-bold text-indigo-600">
            Redirecting...
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Toast notification
        Toastify({
            text: "Submission Successful!",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        }).showToast();

        // Countdown and redirection
        let seconds = 5;
        const countdownEl = document.getElementById('countdown');
        
        const countdownInterval = setInterval(() => {
            seconds--;
            countdownEl.textContent = `Redirecting in ${seconds} seconds...`;
            
            if (seconds <= 0) {
                clearInterval(countdownInterval);
                window.location.href = 'target-page.html'; // Replace with your actual target page
            }
        }, 1000);
    </script>
</body>
</html>