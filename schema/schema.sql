create database if not exists payment_tracker;

use payment_tracker;

create table if not exists users (
    user_id integer unsigned primary key auto_increment,
    role_id integer unsigned,
    username varchar(100) unique,
    password varchar(500),
    name varchar(100),
    budget float,
    photo varchar(300),
    create_at timestamp not null default current_timestamp,
    modified_at timestamp not null default current_timestamp on update current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists roles (
    role_id integer unsigned primary key auto_increment,
    name varchar(40) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists categories (
    category_id integer unsigned primary key auto_increment,
    user_id integer unsigned,
    name varchar(50) unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists expenses (
    expense_id integer unsigned primary key auto_increment,
    category_id integer unsigned,
    user_id integer unsigned,
    name varchar(200) unique,
    amount float,
    create_at timestamp not null default current_timestamp,
    modified_at timestamp not null default current_timestamp on update current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;