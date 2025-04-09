<?php
include 'connect.php';

$query_product = "SELECT id_produk, nama_produk FROM produk";
$products = $conn->query($query_product);

$query_sales = "SELECT id_sales, nama_sales FROM sales";
$sales = $conn->query($query_sales);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Tambah Leads</title>
	<link rel="stylesheet" href="style.css" />
</head>

<body>
	<header>
		<h1>Selamat Datang di Tambah Leads</h1>
	</header>
	<main>
		<section class="content__top">
			<a href="index.php" class="button__back">Kembali</a>
		</section>
		<section class="content__bottom">
			<form id="leadForm" action="submit.php" class="form-leads" method="POST">
				<div class="form-leads__col">
					<div class="form-leads__field">
						<label for="date">Tanggal</label><br />
						<input type="date" id="date" name="date" required /><br />
					</div>
					<div class="form-leads__field">
						<label for="product">Produk</label><br />
						<select name="product" id="product" required>
							<?php while ($row = $products->fetch_assoc()): ?>
								<option value="<?= $row['id_produk'] ?>">
									<?= htmlspecialchars($row['nama_produk']) ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
				</div>
				<div class="form-leads__col">
					<div class="form-leads__field">
						<label for="sales">Sales</label><br />
						<select name="sales" id="sales" required>
							<?php while ($row = $sales->fetch_assoc()): ?>
								<option value="<?= $row['id_sales'] ?>">
									<?= htmlspecialchars($row['nama_sales']) ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-leads__field">
						<label for="no_wa">No. Whatsapp</label><br />
						<input
							type="number"
							maxlength="20"
							id="no_wa"
							name="no_wa"
							required />
					</div>
				</div>
				<div class="form-leads__col">
					<div class="form-leads__field">
						<label for="lead">Nama Lead</label><br />
						<input
							type="text"
							id="lead"
							name="lead"
							maxlength="50"
							required /><br />
					</div>
					<div class="form-leads__field">
						<label for="city">Kota</label><br />
						<input
							type="text"
							id="city"
							name="city"
							maxlength="50"
							required />
					</div>
				</div>
			</form>
			<div class="button__group">
				<button class="button__save" type="submit" form="leadForm">Simpan</button>
				<a href="index.php" class="button__cancel">Cancel</a>
			</div>
		</section>
	</main>
</body>

</html>