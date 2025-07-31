ALTER TABLE `sales`
ADD COLUMN `status` VARCHAR(20) DEFAULT 'draft' AFTER `sales`,
ADD COLUMN `total_harga` DECIMAL(18,2) GENERATED ALWAYS AS (`grand_total`) STORED AFTER `discount`;
