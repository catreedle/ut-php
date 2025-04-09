<?php
include 'connect.php';

$query_leads = "SELECT 
	leads.*, 
	produk.nama_produk, 
	sales.nama_sales
FROM leads
JOIN produk ON leads.id_produk = produk.id_produk
JOIN sales ON leads.id_sales = sales.id_sales;
";
$leads = $conn->query($query_leads);

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
			<select name="product" id="product" required>
				<option value="all">Semua Produk</option>
				<?php while ($row = $products->fetch_assoc()): ?>
					<option value="<?= $row['id_produk'] ?>">
						<?= htmlspecialchars($row['nama_produk']) ?>
					</option>
				<?php endwhile; ?>
			</select>
		</div>

		<div class="form__filter__field">
			<label for="sales">Produk</label><br />
			<select name="sales" id="sales" required>
				<option value="all">Semua Sales</option>
				<?php while ($row = $sales->fetch_assoc()): ?>
					<option value="<?= $row['id_sales'] ?>">
						<?= htmlspecialchars($row['nama_sales']) ?>
					</option>
				<?php endwhile; ?>
			</select>
		</div>

		<div class="form__filter__field calendar">
			<label for="month">Bulan</label>
			<input type="month" id="month" name="month" required />
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
			while ($row = $leads->fetch_assoc()): ?>
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