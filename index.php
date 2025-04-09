<?php
include 'connect.php';

$query_leads = "SELECT 
	leads.*, 
	produk.nama_produk, 
	sales.nama_sales
FROM leads
JOIN produk ON leads.id_produk = produk.id_produk
JOIN sales ON leads.id_sales = sales.id_sales
WHERE 1=1";

$params = [];
$types = "";

// Filter produk
if (isset($_GET['filter_product']) && $_GET['filter_product'] !== '') {
	$query_leads .= " AND leads.id_produk = ?";
	$params[] = $_GET['filter_product'];
	$types .= "i";
}

// Filter sales
if (isset($_GET['filter_sales']) && $_GET['filter_sales'] !== '') {
	$query_leads .= " AND leads.id_sales = ?";
	$params[] = $_GET['filter_sales'];
	$types .= "i";
}

// Filter tanggal
if (isset($_GET['filter_date']) && $_GET['filter_date'] !== '') {
	// dari input type="month", ambil bulan dan tahun aja (format: YYYY-MM)
	$month = $_GET['filter_date'];
	$query_leads .= " AND DATE_FORMAT(tanggal, '%Y-%m') = ?";
	$params[] = $month;
	$types .= "s";
}

$stmt = $conn->prepare($query_leads);
if (!empty($params)) {
	$stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$query_products = "SELECT * from produk";
$products = $conn->query($query_products);

$query_sales = "SELECT * from sales";
$sales = $conn->query($query_sales);
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="stylesheet" href="style.css" />
</head>

<body>

	<div class="header">
		<h1>Daftar Leads</h1>
		<a href="add_lead.php">
			<button class="button__add">Tambah</button>
		</a>
	</div>
	<form class="form__filter">
		<div class="form__filter__field">
			<label for="product">Produk</label><br />
			<select name="filter_product" id="product" onchange="this.form.submit()">
				<option value="" <?= (!isset($_GET['filter_product']) || $_GET['filter_product'] === '') ? 'selected' : '' ?>>Semua Produk</option>
				<?php while ($row = $products->fetch_assoc()): ?>
					<option value=" <?= $row['id_produk'] ?>" <?= (isset($_GET['filter_product']) && $_GET['filter_product'] == $row['id_produk']) ? 'selected' : '' ?>>
						<?= htmlspecialchars($row['nama_produk']) ?>
					</option>
				<?php endwhile; ?>
			</select>
		</div>

		<div class="form__filter__field">
			<label for="sales">Sales</label><br />
			<select name="filter_sales" id="sales" onchange="this.form.submit()">
				<option value="" <?= (!isset($_GET['filter_sales']) || $_GET['filter_sales'] === '') ? 'selected' : '' ?>>Semua Sales</option>
				<?php while ($row = $sales->fetch_assoc()): ?>
					<option value=" <?= $row['id_sales'] ?>" <?= (isset($_GET['filter_sales']) && $_GET['filter_sales'] == $row['id_sales']) ? 'selected' : '' ?>>
						<?= htmlspecialchars($row['nama_sales']) ?>
					</option>
				<?php endwhile; ?>
			</select>
		</div>

		<div class="form__filter__field calendar">
			<label for="month">Bulan</label>
			<input type="month" id="month" name="filter_date" value="<?= $_GET['filter_date'] ?? '' ?>" onchange="this.form.submit()">
		</div>



	</form>
	<main>
		<table>
			<tr>
				<th>No.</th>
				<th>ID Input</th>
				<th>Tanggal</th>
				<th>Sales</th>
				<th>Produk</th>
				<th>Nama Leads</th>
				<th>No Wa</th>
				<th>Kota</th>
			</tr>

			<?php
			$no = 1;
			while ($row = $result->fetch_assoc()): ?>
				<tr>
					<td><?= $no++ ?></td>
					<td><?= htmlspecialchars($row['id_leads']) ?></td>
					<td><?= htmlspecialchars($row['tanggal']) ?></td>
					<td><?= htmlspecialchars($row['nama_sales']) ?></td>
					<td><?= htmlspecialchars($row['nama_produk']) ?></td>
					<td><?= htmlspecialchars($row['nama_lead']) ?></td>
					<td><?= htmlspecialchars($row['no_wa']) ?></td>
					<td><?= htmlspecialchars($row['kota']) ?></td>
				</tr>
			<?php endwhile; ?>
		</table>
	</main>
</body>

</html>