<?php
// online_pay.php

// Check if the payment method is set and valid
if(isset($_GET['method'])) {
    $payment_method = $_GET['method'];

    // Function to sanitize input data
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    // Redirect to respective payment gateway URLs based on the selected method
    switch ($payment_method) {
        case 'gpay':
            // Replace with actual GPay integration logic
            // Example: Generate a payment request and redirect user to GPay payment URL
            $amount = sanitize($_GET['amount']); // Example: Retrieve amount from query string

            // Replace with your actual GPay payment gateway URL or integration logic
            $gpay_payment_url = 'https://pay.google.com/business/console/info/BCR2DN4TWXW5DLJB'; // Replace with actual GPay payment URL

            // Redirect user to GPay payment page
            header('Location: ' . $gpay_payment_url);
            exit;
            break;

        case 'paytm':
            // Replace with actual Paytm integration logic
            // Example: Generate a payment request and redirect user to Paytm payment URL
            $amount = sanitize($_GET['amount']); // Example: Retrieve amount from query string

            // Replace with your actual Paytm payment gateway URL or integration logic
            $paytm_payment_url = 'https://example.com/paytm_payment'; // Replace with actual Paytm payment URL

            // Redirect user to Paytm payment page
            header('Location: ' . $paytm_payment_url);
            exit;
            break;

        case 'phonepe':
            // Replace with actual PhonePe integration logic
            // Example: Generate a payment request and redirect user to PhonePe payment URL
            $amount = sanitize($_GET['amount']); // Example: Retrieve amount from query string

            // Replace with your actual PhonePe payment gateway URL or integration logic
            $phonepe_payment_url = 'https://example.com/phonepe_payment'; // Replace with actual PhonePe payment URL

            // Redirect user to PhonePe payment page
            header('Location: ' . $phonepe_payment_url);
            exit;
            break;

        default:
            // Handle invalid or unsupported payment method
            echo "Invalid payment method.";
            break;
    }
} else {
    // Handle case where payment method parameter is missing
    echo "Payment method not specified.";
}
?>
