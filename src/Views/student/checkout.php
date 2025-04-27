<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$GLOBALS['env'] = require __DIR__ . '/../../Config/env.php';
// Check if payment info exists in session
if (!isset($_SESSION['payment_info'])) {
    // Redirect back to payment page if no payment info found
    header('Location: index.php?action=payment');
    exit;
}

// Get payment info from session
$paymentInfo = $_SESSION['payment_info'];
$amount = $paymentInfo['amount'] ?? 0;
$points = $paymentInfo['points'] ?? 0;

// Include Stripe library
require __DIR__ . '/vendor/autoload.php';

// Stripe API keys
$stripe_secret_key = $GLOBALS['env']['stripe_secret_key'] ;
// Set API key
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Set product description
$productDescription = "$points Points for Online Tutoring";
$productName = "$points Tutoring Points";

// Create checkout session
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/index.php?action=payment_success",
    "cancel_url" => "http://localhost/index.php?action=payment_cancel",
    "customer_email" => $paymentInfo['email'] ?? null,
    "line_items" => [[
        "quantity" => 1,
        "price_data" => [
            "currency" => "lkr", // Indian Rupees
            "unit_amount" => $amount * 100, // Stripe expects amount in cents/smallest currency unit
            "product_data" => [
                "name" => $productName,
                "description" => $productDescription,
                "images" => ["https://localhost/images/student-uploads/points.jpg"]
            ]
        ]
    ]],
    "payment_method_types" => ["card"],
    "billing_address_collection" => "auto",
    "shipping_address_collection" => null,
    "metadata" => [
        "student_id" => $_SESSION['student_id'] ?? 0,
        "points" => $points
    ]
]);

// Redirect to Stripe checkout
http_response_code(303);
header("Location: " . $checkout_session->url);
exit;