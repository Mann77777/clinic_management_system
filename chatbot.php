<?php
header('Content-Type: application/json');

// Predefined responses for simplicity
$responses = [
    "hi" => "Hello! How can I help you today?",
    "hello" => "Hi there! What can I do for you?",
    "how are you" => "I'm just a chatbot, but I'm here to assist you!",
    "what is your name" => "I'm your friendly chatbot!",
    "bye" => "Goodbye! Have a great day!"
];

// Get the user's input from the POST request
$input = strtolower(trim($_POST['message']));

// Check if the input matches any predefined responses
if (array_key_exists($input, $responses)) {
    $response = $responses[$input];
} else {
    $response = "Sorry, I don't understand that. Can you try asking in a different way?";
}

// Return the response as JSON
echo json_encode(['response' => $response]);
?>