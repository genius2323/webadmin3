-- SQL untuk menambah field metode pembayaran dan detail kredit pada tabel penjualan
ALTER TABLE sales
ADD COLUMN metode_bayar VARCHAR(20) DEFAULT 'Cash',
ADD COLUMN tenor INT DEFAULT NULL,
ADD COLUMN dp BIGINT DEFAULT NULL,
ADD COLUMN catatan_kredit VARCHAR(255) DEFAULT NULL;

-- Jika tabel Anda bernama lain, ganti 'penjualan' sesuai kebutuhan.
