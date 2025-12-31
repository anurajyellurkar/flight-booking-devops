
<?php include 'partials/header.php';
if($_POST){$q=$conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,MD5(?))");
$q->bind_param("sss",$_POST['name'],$_POST['email'],$_POST['password']);
echo $q->execute()?"<div class=card>Registered</div>":"<div class=card>Email exists</div>";}
?>
<h2>Register</h2><form class=card method=POST>
<input name=name placeholder=Name required><br><br>
<input type=email name=email placeholder=Email required><br><br>
<input type=password name=password placeholder=Password required><br><br>
<button>Create</button></form><?php include 'partials/footer.php'; ?>
