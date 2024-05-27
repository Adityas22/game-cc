<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
<a id="logout-link" class="nav-link" aria-current="page" href="#">Logout</a>
<script>
document.getElementById('logout-link').addEventListener('click', function(event) {
    event.preventDefault();
    if (confirm('Apakah yakin ingin keluar?')) {
        window.location.href = 'logout.php';
    }
});
</script>