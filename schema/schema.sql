create database if not exists payment_tracker;

use payment_tracker;

create table if not exists users (
    user_id integer unsigned primary key auto_increment,
    username varchar(100) unique,
    password varchar(500),
    first_name varchar(100),
    last_name varchar(100),
    email varchar(80),
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
    role_id integer unsigned,
    primary key (user_id, role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists views (
    view_id integer unsigned primary key,
    view_name varchar(50) not null unique 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table if not exists views_permissions (
    view_id integer unsigned,
    permission_id integer unsigned,
    primary key (view_id, permission_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;