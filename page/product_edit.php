<?php
// session_start();
$apiUrl = 'https://game-game-api-3o2r3t7hxa-et.a.run.app/games';

// Get the game ID from the query parameter
$gameId = $_GET['edit'];

// Fetch the game details from the API
$response = file_get_contents($apiUrl . '/' . $gameId);
$gameData = json_decode($response, true);

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $imageUrl = $_FILES['imageUrl'];
    $genre = $_POST['genre'];

    if (isset($_FILES['imageUrl']) && $_FILES['imageUrl']['error'] == UPLOAD_ERR_OK) {
        $imageUrl = file_get_contents($_FILES['imageUrl']['tmp_name']);
        $imageUrl = base64_encode($imageUrl);
    } else {
        $imageUrl = null; // Jika tidak ada file yang diunggah, set $imageUrl menjadi null
    }

    // Prepare the data for the API update request
    $updatedData = [
        'title' => $title,
        'description' => $description,
        'imageUrl' => $imageUrl,
        'genre' => $genre
    ];

    // Make the API request to update the game
    $ch = curl_init($apiUrl . '/' . $gameId);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updatedData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatus == 200) {
        echo '{"status":"success","message":"Game updated successfully"}';
    } else {
        echo '{"status":"error","message":"Failed to update game"}';
    }

    // Redirect the user back to the main page
    // header('Location: product.php');
    // exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Edit Game</title>
</head>

<body>
    <div class="container my-5">
        <h1>Edit Game</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="imageUrl" class="form-label">Image</label>
                <input type="file" id="imageUrl" name="imageUrl" accept="image/*" max-file-size="2097152" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>
<script>
document.querySelector('#imageUrl').addEventListener('change', function() {
    var fileInput = this;
    var maxFileSize = 2 * 1024 * 1024; // 2 MB

    if (fileInput.files[0].size > maxFileSize) {
        alert('File size exceeds the maximum limit of 2 MB.');
        fileInput.value = '';
    }
});
</script>