<?php
session_start();
$apiUrl = 'https://game-game-api-3o2r3t7hxa-et.a.run.app/games';

// Cek apakah sesi pengguna sudah aktif dan ID sudah diset
if (!isset($_SESSION['user_id'])) {
    echo "ID pengguna tidak ditemukan. Silakan login terlebih dahulu.";
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Login!</title>
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
                <h2>GAME</h2>
                <br>
                <a href="product_tambah.php?idUser=<?= $user_id ?>" class="btn text-bg-success">Tambah Data</a>
                <br>
                <table class="table table-dark table-hover table-md">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Genre</th>
                            <th scope="col" colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $response = file_get_contents($apiUrl);
                        $data = json_decode($response, true);

                        $i = 0;

                        foreach ($data['data'] as $game) {
                            $i++;
                            ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $game['title']; ?></td>
                            <td><?= $game['genre']; ?></td>
                            <td>
                                <?php if ($game['idUser'] == $user_id) { ?>
                                <a href="product_edit.php?edit=<?= $game['id']; ?>"><button
                                        class="btn btn-sm btn-outline-light" type="button">Edit</button></a>
                                <a href="product_hapus.php?delete=<?= $game['id']; ?>"><button
                                        class="btn btn-sm btn-outline-danger" type="button">Delete</button></a>
                                <?php } ?>
                                <a href="product_detail.php?detail=<?= $game['id']; ?>"><button
                                        class="btn btn-sm btn-outline-primary" type="button">Detail</button></a>
                            </td>
                        </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </center>

</body>

</html>