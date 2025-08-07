<?php
// API sederhana untuk data sales (pegawai)
header('Content-Type: application/json');

// Koneksi manual ke MySQLi
$mysqli = new mysqli('localhost', 'root', '', 'db_akuntansi');
if ($mysqli->connect_errno) {
    echo json_encode([]);
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT kode, nama FROM mastersales WHERE deleted_at IS NULL";
if ($search !== '') {
    $search = $mysqli->real_escape_string($search);
    $sql .= " AND (kode LIKE '%$search%' OR nama LIKE '%$search%')";
}
$sql .= " ORDER BY nama ASC LIMIT 30";

$result = $mysqli->query($sql);
$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$mysqli->close();
echo json_encode($data);
