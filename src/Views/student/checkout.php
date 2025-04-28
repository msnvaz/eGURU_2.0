<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$GLOBALS['env'] = require __DIR__ . '/../../Config/env.php';

if (!isset($_SESSION['payment_info'])) {
    
    header('Location: index.php?action=payment');
    exit;
}


$paymentInfo = $_SESSION['payment_info'];
$amount = $paymentInfo['amount'] ?? 0;
$points = $paymentInfo['points'] ?? 0;


require __DIR__ . '/vendor/autoload.php';


$stripe_secret_key = $GLOBALS['env']['stripe_secret_key'] ;

\Stripe\Stripe::setApiKey($stripe_secret_key);


$productDescription = "$points Points for Online Tutoring";
$productName = "$points Tutoring Points";


$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/index.php?action=payment_success",
    "cancel_url" => "http://localhost/index.php?action=payment_cancel",
    "customer_email" => $paymentInfo['email'] ?? null,
    "line_items" => [[
        "quantity" => 1,
        "price_data" => [
            "currency" => "lkr", 
            "unit_amount" => $amount * 100, 
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


http_response_code(303);
header("Location: " . $checkout_session->url);
exit;