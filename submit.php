<?php
include 'connect.php';

$tanggal = $_POST['date'];
$id_produk = $_POST['product'];
$id_sales = $_POST['sales'];
$no_wa = $_POST['no_wa'];
$nama_lead = $_POST['lead'];
$kota = $_POST['city'];

function getNameById($conn, $table, $id_field, $name_field, $id_value)
{
	$name = '';
	$stmt = $conn->prepare("SELECT $name_field FROM $table WHERE $id_field = ?");
	$stmt->bind_param("i", $id_value);
	$stmt->execute();
	$stmt->bind_result($name);
	$stmt->fetch();
	$stmt->close();
	return $name;
}

$nama_produk = getNameById($conn, 'produk', 'id_produk', 'nama_produk', $id_produk);
$nama_sales = getNameById($conn, 'sales', 'id_sales', 'nama_sales', $id_sales);


if ($tanggal && $id_produk && $id_sales && $no_wa && $nama_lead && $kota) {
	$stmt = $conn->prepare("INSERT INTO leads (tanggal, id_produk, id_sales, no_wa, nama_lead, kota) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("siisss", $tanggal, $id_produk, $id_sales, $no_wa, $nama_lead, $kota);

	if ($stmt->execute()) {
		echo "Data berhasil disimpan!";
		header("Location: index.php");
		exit;
	} else {
		echo "Gagal menyimpan data: " . $stmt->error;
	}

	$stmt->close();
} else {
	echo "Mohon isi semua field.";
}

$conn->close();
