CREATE DATABASE e_canteen;

CREATE TABLE store (
	store_id INT AUTO_INCREMENT,
  	store_brand VARCHAR(50),
  	opening_time TIME,
  	closing_time TIME,
  	store_password VARCHAR(50),
  	store_image VARCHAR(255),
	store_availability VARCHAR(10),
  	CONSTRAINT PK_store PRIMARY KEY(store_id)
);

/*Klo udh run query nya sebelum update run command ini bawah*/
-- ALTER TABLE store ADD store_availability VARCHAR(10); --

CREATE TABLE product (
	product_id INT AUTO_INCREMENT,
  	store_id INT,
  	product_price INT,
  	product_availability BIT,
  	product_image VARCHAR(255),
	product_description VARCHAR(255),
	product_name VARCHAR(255),
  	CONSTRAINT PK_product PRIMARY KEY(product_id),
  	CONSTRAINT FK_storeid_product FOREIGN KEY(store_id)
  	REFERENCES store(store_id)
);
-- ALTER TABLE product ADD product_description VARCHAR(255) --
-- ALTER TABLE product ADD product_name VARCHAR(255); --

CREATE TABLE customer(
	customer_id INT AUTO_INCREMENT,
  	customer_name VARCHAR(50),
  	customer_number VARCHAR(15),
  	CONSTRAINT PK_customer PRIMARY KEY(customer_id)
);

CREATE TABLE orders (
	order_id INT AUTO_INCREMENT,
  	store_id INT,
  	customer_id INT,
  	order_date DATE,
  	order_note VARCHAR(255),
  	order_seat INT,
  	CONSTRAINT PK_order PRIMARY KEY(order_id),
  	CONSTRAINT FK_storeid_order FOREIGN KEY(store_id)
  	REFERENCES store(store_id),
  	CONSTRAINT FK_customerId_order FOREIGN KEY(customer_id)
  	REFERENCES customer(customer_id)
);

CREATE TABLE masterkey(
	order_id INT,
  	product_id INT,
  	quantity INT,
  	total_price INT,
  	CONSTRAINT FK_orderid_masterkey FOREIGN KEY(order_id)
  	REFERENCES orders(order_id),
	CONSTRAINT FK_productid_masterkey FOREIGN KEY(product_id)
  	REFERENCES product(product_id)
);

CREATE TABLE payment(
	payment_id INT AUTO_INCREMENT,
  	order_id INT,
  	total_price INT,
  	payment_status VARCHAR(15),
  	CONSTRAINT PK_paymentid PRIMARY KEY(payment_id),
  	CONSTRAINT FK_orderid_payment FOREIGN KEY(order_id)
  	REFERENCES orders(order_id)
);











