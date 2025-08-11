ALTER TABLE mastercustomer
ADD COLUMN sales_id INT NULL AFTER provinsi;
ALTER TABLE mastercustomer
DROP COLUMN sales;
