
<?php require '../config.php'; include 'header.php'; ?>
<h2>Audit Log</h2>
<table class='table'>
<tr><th>Date</th><th>User</th><th>Role</th><th>Action</th><th>Details</th></tr>
<?php $r=$conn->query("SELECT * FROM audit_log ORDER BY id DESC LIMIT 200");
while($x=$r->fetch_assoc()): ?>
<tr>
<td><?=$x['created_at']?></td>
<td><?=$x['user_id']?></td>
<td><?=$x['role']?></td>
<td><?=$x['action']?></td>
<td><?=$x['details']?></td>
</tr>
<?php endwhile; ?>
</table>
<?php include 'footer.php'; ?>
