
<?php include 'partials/header.php';
if($_POST){$q=$conn->prepare("SELECT * FROM users WHERE email=? AND password=MD5(?)");
$q->bind_param("ss",$_POST['email'],$_POST['password']);$q->execute();$u=$q->get_result()->fetch_assoc();
if($u){$_SESSION['user']=$u;header("Location:index.php");exit;} echo "<div class=card>Invalid</div>";}
?>
<h2>Login</h2><form class=card method=POST>
<input name=email placeholder=Email><br><br><input type=password name=password placeholder=Password><br><br>
<button>Login</button></form><?php include 'partials/footer.php'; ?>
