<?php
session_start(); // Make sure session is started

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = isset($_POST['idUser']) ? $_POST['idUser'] : null;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $genre = isset($_POST['genre']) ? $_POST['genre'] : null;
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    if ($idUser && $title && $description && $genre) {
        $url = "https://game-game-api-3o2r3t7hxa-et.a.run.app/games";
        $data = [
            'idUser' => $idUser,
            'title' => $title,
            'description' => $description,
            'genre' => $genre
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        if ($image && $image['tmp_name']) {
            $data['image'] = new CURLFile($image['tmp_name'], $image['type'], $image['name']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "Response: $response";
        echo "HTTP Status Code: $http_code";
    } else {
        echo "All fields are required.";
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

    .btn-submit {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-submit:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h1 class="text-center mb-4"> Add Game</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idUser" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <button type="submit" class="btn btn-submit">Add</button>
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