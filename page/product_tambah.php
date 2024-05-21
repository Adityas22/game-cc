<?php
// session_start();
$apiUrl = 'https://game-game-api-3o2r3t7hxa-et.a.run.app/games';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $idUser = $_GET['idUser']; // Ambil idUser dari GET parameter
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $imageUrl = $_FILES['imageUrl']['name'];
    $description = $_POST['description'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imageUrl"]["name"]);
    if (move_uploaded_file($_FILES["imageUrl"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["imageUrl"]["name"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    // Prepare data for API request
    $data = array(
        'idUser' => $idUser,
        'title' => $title,
        'genre' => $genre,
        'imageUrl' => $imageUrl,
        'description' => $description
    );

    // Send POST request to API
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );
    $context  = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    if ($response === false) {
        echo "Error: Unable to connect to the API.";
    } else {
        echo "Data saved successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Add Game</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Add Game</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="mb-3">
                <label for="imageUrl" class="form-label">Image</label>
                <input type="file" class="form-control" id="imageUrl" name="imageUrl" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>

</html>