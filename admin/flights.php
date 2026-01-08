<?php include 'dashboard_header.php'; ?>
<?php include 'auth.php';

if(isset($_POST['add'])){
 $s=$conn->prepare("INSERT INTO flights(aircraft_type,flight_no,origin,destination,depart_time,arrive_time,price_economy,price_business,total_seats)
                    VALUES(?,?,?,?,?,?,?,?,?)");
 $s->bind_param("sssssddii",
   $_POST['no'],$_POST['ac'], $_POST['o'],$_POST['d'],
   $_POST['dt'],$_POST['at'],
   $_POST['pe'],$_POST['pb'],
   $_POST['ts']
 );
 $s->execute();
}

if(isset($_GET['del'])){
  $conn->query("DELETE FROM flights WHERE id=".intval($_GET['del']));
}

$r=$conn->query("SELECT * FROM flights ORDER BY id DESC");
?>
<div class=card><a href="bookings.php">Bookings</a></div>

<div class=card>
<h3>Add Flight</h3>
<form method=POST>
  <input name=no placeholder="Flight No" required>
  <input name=o placeholder="From" required>
  <input name=d placeholder="To" required><br><br>

  Depart <input type=datetime-local name=dt required>
  Arrive <input type=datetime-local name=at required><br><br>

  Economy <input type=number step=.01 name=pe required>
  Business <input type=number step=.01 name=pb required>
  Aircraft <select name='ac'><option value='A320'>A320</option><option value='B737'>B737</option></select><br><br>
Seats <input type='number' name='ts' value='30' min='1' required><br><br>

  <button name=add>Add Flight</button>
</form>
</div>

<table class=table>
<tr>
  <th>No</th>
  <th>Route</th>
  <th>Economy</th>
  <th>Business</th>
  <th>Total Seats</th>
  <th>Delete</th>
</tr>
<?php while($f=$r->fetch_assoc()): ?>
<tr>
  <td><?=$f['flight_no']?></td>
  <td><?=$f['origin']?> → <?=$f['destination']?></td>
  <td>₹<?=$f['price_economy']?></td>
  <td>₹<?=$f['price_business']?></td>
  <td><?=$f['total_seats']?></td>
  <td><a href="?del=<?=$f['id']?>">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php echo '</div></body></html>'; ?>