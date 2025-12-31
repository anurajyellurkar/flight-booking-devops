<?php
session_start();
include 'config.php';

if ($_POST) {
    $q = $conn->prepare("SELECT * FROM users WHERE email=? AND password=MD5(?)");
    $q->bind_param("ss", $_POST['email'], $_POST['password']);
    $q->execute();
    $u = $q->get_result()->fetch_assoc();

    if ($u) {
        $_SESSION['user'] = $u;
        header("Location: index.php");
        exit;
    }

    $error = "Invalid email or password";
}
?>

<?php include 'partials/header.php'; ?>

<h2>Login</h2>

<?php if (!empty($error)): ?>
<div class="card" style="color:red;">
    <?= $error ?>
</div>
<?php endif; ?>

<form class="card" method="POST">
    <input name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>
    <button>Login</button>
</form>

<?php include 'partials/footer.php'; ?>
