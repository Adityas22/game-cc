<?php
// Pastikan tidak ada output sebelum header
ob_start();

$apiUrl = 'https://game-api-game-f5h63tksnq-et.a.run.app/games';

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
        $errorMessage = "Error deleting the game: " . $error;
    } else {
        // Check the HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            // Game deleted successfully
            curl_close($ch);
            ob_end_clean(); // Clear the output buffer
            header("Location: product.php");
            exit;
        } else {
            // Error deleting the game
            $errorMessage = "Error deleting the game. HTTP status code: " . $httpCode;
        }
    }

    // Close the cURL session
    curl_close($ch);

    // If there was an error, show the error message
    if (isset($errorMessage)) {
        echo $errorMessage;
    }
} else {
    echo "No game ID specified for deletion.";
}
?>