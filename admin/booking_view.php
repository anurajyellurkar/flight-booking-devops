<?php
require '../config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);

$b = $conn->query("
SELECT b.*, f.flight_no, f.aircraft_type
FROM bookings b
LEFT JOIN flights f ON f.id = b.flight_id
WHERE b.id = $id
")->fetch_assoc();

// load main header
include __DIR__ . '/../partials/header.php';
?>

<h3 class="mt-3">Booking #<?= $b['id'] ?></h3>

<table class="table table-bordered w-50">
<tr>
    <th>Flight</th>
    <td><?= $b['flight_no'] ?> (<?= $b['aircraft_type'] ?>)</td>
</tr>

<tr>
    <th>Total</th>
    <td>₹<?= number_format($b['total_price'],2) ?></td>
</tr>
</table>

<h5 class="mt-3">Passengers</h5>

<table class="table table-striped">
<thead class="table-dark">
<tr>
    <th>Name</th>
    <th>Seat</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
$ps = $conn->query("
SELECT * FROM passengers
WHERE booking_id = $id
");

while($p = $ps->fetch_assoc()):
?>

<tr>
    <td><?= $p['name'] ?></td>

    <td><?= $p['seat_no'] ?></td>

    <td>
        <?php if($p['cancel_status'] == 'ACTIVE'): ?>
            <span class="badge bg-success">ACTIVE</span>
        <?php else: ?>
            <span class="badge bg-danger">CANCELLED</span>
        <?php endif; ?>
    </td>

    <td>
        <?php if($p['cancel_status'] == 'ACTIVE'): ?>
        <a class="btn btn-sm btn-danger"
           onclick="return confirm('Cancel this passenger ticket?')"
           href="cancel_passenger.php?id=<?= $p['id'] ?>">
           Cancel
        </a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>

<?php endwhile; ?>

</tbody>
</table>

<?php
// load main footer
include __DIR__ . '/../partials/footer.php';
?>