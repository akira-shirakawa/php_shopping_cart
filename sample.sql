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