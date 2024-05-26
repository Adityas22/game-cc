<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $genre = isset($_POST['genre']) ? $_POST['genre'] : null;
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    if ($id && $title && $description && $genre) {
        $url = "https://game-game-api-3o2r3t7hxa-et.a.run.app/games/$id";
        $data = [
            'title' => $title,
            'description' => $description,
            'genre' => $genre
        ];

        if ($image && $image['tmp_name']) {
            $data['image'] = new CURLFile($image['tmp_name'], $image['type'], $image['name']);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200 || $http_code == 201) { // Assuming 200 or 201 means success
            header('Location: product.php');
            exit();
        } else {
            echo "Update failed. Response: $response. HTTP Status Code: $http_code";
        }
    } else {
        echo "All fields are required.";
    }
} else {
    $gameId = isset($_GET['edit']) ? $_GET['edit'] : null;

    if ($gameId) {
        $apiUrl = 'https://game-game-api-3o2r3t7hxa-et.a.run.app/games/' . $gameId;
        $response = file_get_contents($apiUrl);
        $gameData = json_decode($response, true);
    } else {
        die("Game ID is required.");
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
    <title>Edit Game</title>
    <style>
    body {
        background-color: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .form-container {
        background-color: #333;
        padding: 20px;
        border-radius: 8px;
        color: white;
        width: 100%;
        max-width: 500px;
    }

    .form-label {
        color: white;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h1 class="text-center mb-4">Edit Game</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($gameId) ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="<?= htmlspecialchars($gameData['data']['title'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"
                    required><?= htmlspecialchars($gameData['data']['description'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre"
                    value="<?= htmlspecialchars($gameData['data']['genre'] ?? '') ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>
<script>
document.querySelector('#image').addEventListener('change', function() {
    var fileInput = this;
    var maxFileSize = 2 * 1024 * 1024; // 2 MB

    if (fileInput.files[0].size > maxFileSize) {
        alert('File size exceeds the maximum limit of 2 MB.');
        fileInput.value = '';
    }
});
</script>