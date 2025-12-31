
<?php include 'partials/header.php'; ?>
<h2>Search Flights</h2>
<form class=card method=GET action=search.php>
From<br><input name=origin required><br><br>
To<br><input name=destination required><br><br>
Date<br><input type=date name=date required><br><br>
<button>Search</button>
<br><b>Filters</b><br>
Class:
<select name="class_filter">
<option value="">Any</option>
<option value="ECONOMY">Economy</option>
<option value="BUSINESS">Business</option>
</select>
Max Price: <input type="number" name="max_price" value="0">
</form>

<?php include 'partials/footer.php'; ?>
