alter table expenses
    add constraint category_expense_id foreign key (category_id) references categories (category_id),
    add constraint user_expense_id foreign key (user_id) references users (user_id);
