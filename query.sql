INSERT INTO supplier (supplier_name, phone_number_person, email_person, supplier_company, phone_number_company, address_company, status, created_at, updated_at)
VALUES
('John Doe', 123456789, 'john.doe@example.com', 'Company A', 987654321, 'Address A', 'Y', NOW(), NOW()),
('Jane Smith', 987654321, 'jane.smith@example.com', 'Company B', 123456789, 'Address B', 'Y', NOW(), NOW()),
('Michael Johnson', 555555555, 'michael.johnson@example.com', 'Company C', 111111111, 'Address C', 'Y', NOW(), NOW());


INSERT INTO ctgr_product (ctgr_product_code, ctgr_product_name, status, record_id, created_at, updated_at)
VALUES
('CTGR001', 'KOMPUTER', 'Y', 1, NOW(), NOW()),
('CTGR002', 'HANDPHONE', 'Y', 1, NOW(), NOW()),
('CTGR003', 'LAPTOP', 'Y', 1, NOW(), NOW()),
('CTGR005', 'AKSESORIS HANDPHONE', 'Y', 1, NOW(), NOW());

INSERT INTO sub_ctgr_product (ctgr_product_id, sub_ctgr_product_code, sub_ctgr_product_name, status, record_id, created_at, updated_at)
VALUES
(1, 'SUBCTGR001', 'MOTHERBOARD', 'Y', 1, NOW(), NOW()),
(2, 'SUBCTGR002', 'IPHONE', 'Y', 1, NOW(), NOW()),
(3, 'SUBCTGR003', 'LAPTOP GAMING', 'Y', 1, NOW(), NOW()),
(4, 'SUBCTGR004', 'CASE', 'Y', 1, NOW(), NOW()),
(1, 'SUBCTGR005', 'PSU', 'Y', 1, NOW(), NOW()),
(2, 'SUBCTGR006', 'HP GAMING', 'Y', 1, NOW(), NOW()),
(3, 'SUBCTGR007', 'CHROMEBOOK', 'Y', 1, NOW(), NOW()),
(4, 'SUBCTGR008', 'PROTECTOR HP', 'Y', 1, NOW(), NOW());


INSERT INTO product (sub_ctgr_product_id, product_code, product_name, merek, product_purcase, product_price, diskon, status, record_id, created_at, updated_at)
VALUES
(1, 'PROD001', 'Gigabyte B60M', 'Gigabyte', 2000000, 2100000, 3, 'Y', 1, NOW(), NOW()),
(1, 'PROD002', 'MSI Intel Edition', 'MSI', 4300000, 4500000, 0, 'Y', 1, NOW(), NOW()),
(2, 'PROD003', 'Iphone 14 PRO MAX', 'Iphone', 23000000, 23200000, 0, 'Y', 1, NOW(), NOW()),
(3, 'PROD004', 'Lenovo LOQ 16GB', 'Lenovo', 15000000, 15999999, 0, 'Y', 1, NOW(), NOW()),
(3, 'PROD005', 'ASUS ROG TIMELINE', 'ASUS', 65000000, 65300000, 0, 'Y', 1, NOW(), NOW()),
(3, 'PROD006', 'Acer Predator By45', 'Acer', 2400000, 24300000, 0, 'Y', 1, NOW(), NOW()),
(4, 'PROD007', 'Powerful Case', 'Powefull', 50000, 50200, 0, 'Y', 1, NOW(), NOW()),
(5, 'PROD008', 'Coler Master 80+ Bronze 600 wat', 'Color Master', 3000000, 3200000, 50, 'Y', 1, NOW(), NOW()),
(6, 'PROD009', 'Asus ROG Phone 6', 'ASUS', 12000000, 12300000, 0, 'Y', 1, NOW(), NOW()),
(7, 'PROD010', 'Samsung ChromeBook Pro', 'Samsung', 200000, 2300000, 0, 'Y', 1, NOW(), NOW()),
(8, 'PROD011', 'KomoGami Glex 67', 'Komogami', 45000, 50000, 0,  'Y', 1, NOW(), NOW());

INSERT INTO stok (product_id, total_stok, update_stok_date, created_at, updated_at)
VALUES
(1, 100, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(2, 150, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(3, 75, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(4, 200, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(5, 120, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(6, 90, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(7, 180, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(8, 50, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(9, 160, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(10, 110, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(11, 130, CURDATE(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);



