<?php
require '../config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// use main site header/footer
include __DIR__ . '/../partials/header.php';
?>

<h2 class="mt-3 mb-3">All Bookings</h2>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>Ticket</th>
    <th>User</th>
    <th>Passengers</th>
    <th>Total</th>
    <th>Status</th>
    <th>View</th>
</tr>
</thead>

<tbody>

<?php
$q = $conn->query("
SELECT b.*, u.name AS user_name
FROM bookings b
LEFT JOIN users u ON u.id = b.user_id
ORDER BY b.id DESC
");

while ($b = $q->fetch_assoc()):

    $ps = $conn->query("
        SELECT name, seat_no, cancel_status 
        FROM passengers 
        WHERE booking_id = {$b['id']}
    ");
?>

<tr>
    <td><strong><?= $b['ticket_no'] ?></strong></td>

    <td><?= $b['user_name'] ?></td>

    <td>
        <?php while ($p = $ps->fetch_assoc()): ?>
            <?= $p['name'] ?> (Seat <?= $p['seat_no'] ?>)
            
            <?php if ($p['cancel_status'] != 'ACTIVE'): ?>
                <span class="badge bg-danger ms-1">cancelled</span>
            <?php endif; ?>
            <br>
        <?php endwhile; ?>
    </td>

    <td>₹<?= number_format($b['total_price'], 2) ?></td>

    <td>
        <?php if ($b['cancel_status'] == 'ACTIVE'): ?>
            <span class="badge bg-success">ACTIVE</span>
        <?php else: ?>
            <span class="badge bg-secondary"><?= $b['cancel_status'] ?></span>
        <?php endif; ?>
    </td>

    <td>
        <a class="btn btn-primary btn-sm"
           href="booking_view.php?id=<?= $b['id'] ?>">
           View
        </a>
    </td>
</tr>

<?php endwhile; ?>

</tbody>
</table>

<?php
include __DIR__ . '/../partials/footer.php';
?>