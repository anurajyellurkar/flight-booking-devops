
<?php require '../config.php';
if($_POST){$s=$conn->prepare("SELECT * FROM users WHERE email=? AND password=MD5(?) AND role='admin'");
$s->bind_param("ss",$_POST['email'],$_POST['password']);$s->execute(); if($a=$s->get_result()->fetch_assoc()){$_SESSION['admin']=$a; header('Location:flights.php');exit;}}
?>
<form method=POST><h2>Admin</h2><input name=email><br><br><input name=password type=password><br><br><button>Login</button></form>
