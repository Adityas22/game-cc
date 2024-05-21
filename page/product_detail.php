<?php
// session_start();
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
                <h2>Game List</h2>
                <br>
                <br>
                <table class="table table-dark table-hover table-md">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID</th>
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
                        $response = file_get_contents($apiUrl.'/'.$productId) ;
                        $data = json_decode($response, true);

                        $i = 0;
                        foreach ($data['data'] as $game) {
                            $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $game['id'] ?></td>
                            <td><?= ($game['title']) ?></td>
                            <td><?= ($game['genre']) ?></td>
                            <td><?= ($game['description']) ?></td>
                            <td><img src="<?= ($game['imageUrl']) ?>" alt="<?= ($game['title']) ?>" width="100"></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </center>

</body>

</html>