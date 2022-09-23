create table b_transactions
(
    id               int auto_increment primary key,
    transaction_ref  varchar(35) not null,
    account          varchar(25) not null,
    amount           decimal(10, 2) not null,
    transaction_time timestamp default curtime() null,
    constraint b_transactions_id_uindex unique (id),
    constraint b_transactions_transaction_ref_uindex unique (transaction_ref)
);

INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (1, 'NBC-Y-100001', 'YACC123456789', 5000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (2, 'NBC-Y-100002', 'YACC123456790', 20100.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (3, 'NBC-Y-100005', 'YACC123456793', 5000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (4, 'NBC-Y-100006', 'YACC123456794', 5010.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (5, 'NBC-Y-100007', 'YACC123456795', 7500.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (6, 'NBC-Y-100008', 'YACC123456796', 17000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (7, 'NBC-Y-100009', 'YACC123456797', 45000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (8, 'NBC-X-000001', 'XACC123456789', 7000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (9, 'NBC-X-000002', 'XACC123456790', 100100.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (10, 'NBC-X-000003', 'XACC123456791', 100.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (11, 'NBC-X-000006', 'XACC123456794', 5000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (12, 'NBC-X-000007', 'XACC123456795', 7500.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (13, 'NBC-X-000010', 'XACC123456798', 3000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (14, 'WRONG-100009', 'YACC623456797', 46000.00, '2022-02-16 08:29:12');
INSERT INTO b_transactions (id, transaction_ref, account, amount, transaction_time) VALUES (15, 'WRONG-100239', 'YACC632456797', 26000.00, '2022-02-16 08:29:12');

