alter table expenses
    add constraint category_expense_id foreign key (category_id) references categories (category_id),
    add constraint user_expense_id foreign key (user_id) references users (user_id);

alter table users
    add constraint user_role_id foreign key (role_id) references roles (role_id);

alter table role_permissions
    add constraint role_id foreign key (role_id) references roles (role_id),
    add constraint permission_id foreign key (permission_id) references permissions (permission_id);