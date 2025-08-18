<?php
// Script sinkronisasi status penjualan antara db1 dan db2 berdasarkan id
$db1 = \Config\Database::connect();
$db2 = \Config\Database::connect('db2');

// Ambil semua data penjualan dari db1
$penjualanDb1 = $db1->table('sales')->select('id, status')->where('deleted_at', null)->get()->getResultArray();

foreach ($penjualanDb1 as $row) {
    // Ambil status dari db2
    $rowDb2 = $db2->table('sales')->select('status')->where('id', $row['id'])->where('deleted_at', null)->get()->getRowArray();
    if ($rowDb2 && strtolower($row['status']) !== strtolower($rowDb2['status'])) {
        // Update status di db2 agar sama dengan db1
        $db2->table('sales')->where('id', $row['id'])->update(['status' => $row['status']]);
    }
}

echo "Sinkronisasi status penjualan selesai.";
