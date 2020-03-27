<?php
require_once 'vendor/autoload.php';
require_once 'config/db.php';
require_once 'lib/Database.php';
require_once 'models/Customer.php';
require_once 'models/Transaction.php';

\Stripe\Stripe::setApiKey('sk_test_pvefsoHd92mItGI4j6uEgwTB00Md380D9U');

// Sanitize POST Array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $POST['stripeToken'];

// Create Customer In Stripe
$customer = \Stripe\Customer::create([
    'email' => $email,
    'source' => $token
]);

// Charge Customer
$charge = \Stripe\Charge::create([
    'amount' => 400,
    'currency' => 'usd',
    'description' => 'Orange',
    'customer' => $customer->id
]);

// Customer Data
$customerData = [
    'id' => $charge->customer,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'email' => $email
];

// Instantiate Customer
$customer = new Customer();

// Add Customer To DB
$customer->addCustomer($customerData);


// Transaction Data
$transactionData = [
    'id' => $charge->id,
    'customer_id' => $charge->customer,
    'product' => $charge->description,
    'amount' => $charge->amount,
    'currency' => $charge->currency,
    'status' => $charge->status
];

// Instantiate Transaction
$transaction = new Transaction();

// Add Transaction To DB
$transaction->addTransaction($transactionData);

// Redirect to success
header('location: success.php?tid=' . $charge->id . '&product=' . $charge->description);