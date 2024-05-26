<?php

$apiUrl = 'https://game-game-api-3o2r3t7hxa-et.a.run.app/games';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Detail Produk</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="col mt-5"><br></div>

    <center>
        <div class="row text-bg-dark text-center container-lg mt-3 p-3 my-md-4 bd-layout" style="border-radius: 5%;">
            <div class="col-sm-auto mx-auto">
                <br>
                <h2>Game Detail</h2>
                <br>
                <br>
                <table class="table table-dark table-hover table-md">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $productId = $_GET['detail'];
                        // Fetch game data from the API
                        $response = file_get_contents($apiUrl . "/" . $productId);
                        $data = json_decode($response, true);

                        if ($data['status'] === 'success') {
                            $game = $data['data'];
                        ?>
                        <tr>
                            <td>1</td>
                            <td><?= htmlspecialchars($game['id']) ?></td>
                            <td><?= htmlspecialchars($game['idUser']) ?></td>
                            <td><?= htmlspecialchars($game['title']) ?></td>
                            <td><?= htmlspecialchars($game['genre']) ?></td>
                            <td><?= htmlspecialchars($game['description']) ?></td>
                            <td><img src="<?= htmlspecialchars($game['imageUrl']) ?>"
                                    alt="<?= htmlspecialchars($game['title']) ?>" width="100"></td>
                        </tr>
                        <?php
                        } else {
                            echo "<tr><td colspan='7'>Game not found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </center>

</body>

</html>