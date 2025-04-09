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