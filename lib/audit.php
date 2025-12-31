
<?php
function log_action($conn,$uid,$role,$action,$details){
 $st=$conn->prepare("INSERT INTO audit_log(user_id,role,action,details) VALUES(?,?,?,?)");
 $st->bind_param("isss",$uid,$role,$action,$details);
 $st->execute();
}
?>
