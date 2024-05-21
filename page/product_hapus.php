<?php
// session_start();
$apiUrl = 'https://game-game-api-3o2r3t7hxa-et.a.run.app/games';

// Check if the 'delete' parameter is set in the URL
if (isset($_GET['delete'])) {
    $gameId = $_GET['delete'];

    // Prepare the API endpoint for deleting the game
    $deleteUrl = $apiUrl . '/' . $gameId;

    // Initialize a cURL session
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $deleteUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Check for any cURL errors
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        echo "Error deleting the game: " . $error;
    } else {
        // Check the HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 204) {
            // Game deleted successfully
            echo "Game deleted successfully.";
        } else {
            // Error deleting the game
            echo "Error deleting the game. HTTP status code: " . $httpCode;
        }
    }

    // Close the cURL session
    curl_close($ch);

    // Redirect back to the main page
    header("Location: product.php");
    exit;
}
?>