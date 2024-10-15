create database if not exists payment_tracker;

use payment_tracker;

create table if not exists categories (
    category_id integer unsigned primary key auto_increment,
    user_id integer unsigned,
    category_name varchar(50) unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists expenses (
    expense_id integer unsigned primary key auto_increment,
    category_id integer unsigned,
    user_id integer unsigned,
    expense_name varchar(200) unique,
    amount float,
    created_at timestamp not null default current_timestamp,
    modified_at timestamp not null default current_timestamp on update current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists users (
    user_id integer unsigned primary key auto_increment,
    username varchar(100) unique,
    password varchar(500),
    name varchar(100),
    budget float,
    photo varchar(300),
    created_at timestamp not null default current_timestamp,
    modified_at timestamp not null default current_timestamp on update current_timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists roles (
    role_id integer unsigned primary key auto_increment,
    role_name varchar(40) not null unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists permissions (
    permission_id integer unsigned primary key auto_increment,
    permission_name varchar(100) not null unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists role_permissions (
    role_id integer unsigned,
    permission_id integer unsigned,
    primary key (role_id, permission_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists user_roles (
    user_id integer unsigned,
    role_id integer unsigned
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;