CREATE TABLE shopping_cart.items (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(255),
    caption VARCHAR(255),
   file_name VARCHAR(255), 
    file_path VARCHAR(255),
    price INT(11)
);
CREATE TABLE shopping_cart.sales (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    item_id int(11),
    amount INT(11)
);
alter table sales add constraint fk
foreign key (item_id) references items (id)
on delete cascade on update cascade;
CREATE TABLE shopping_cart.carts (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    comment VARCHAR(255),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
alter table shopping_cart.sales add cart_id Int(11);
alter table sales add constraint fk2 foreign key (cart_id) references carts (id) on delete cascade on update cascade