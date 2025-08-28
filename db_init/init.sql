-- データベース
CREATE DATABASE IF NOT EXISTS nutrition_app CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE nutrition_app;

-- users
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    height FLOAT,
    weight FLOAT,
    age INT
);
INSERT INTO users (username, height, weight, age) VALUES
('alice',160,55,25),
('bob',175,70,30),
('carol',165,60,28);

-- foods
DROP TABLE IF EXISTS foods;
CREATE TABLE foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    calories FLOAT NOT NULL,
    protein FLOAT NOT NULL,
    fat FLOAT NOT NULL,
    carb FLOAT NOT NULL,
    fiber FLOAT NOT NULL
);
INSERT INTO foods (name, calories, protein, fat, carb, fiber) VALUES
('ごはん',168,2.5,0.3,37.1,0.5),
('食パン',265,9,3.2,49,2.7),
('バナナ',89,1.1,0.3,23,2.6),
('鶏胸肉',165,31,3.6,0,0),
('卵',155,13,11,1.1,0),
('納豆',200,17,10,14,5),
('牛乳',42,3.4,1,5,0),
('ヨーグルト',59,10,0.4,3.6,0),
('アーモンド',579,21,50,22,12),
('オリーブオイル',884,0,100,0,0),
('トマト',18,0.9,0.2,3.9,1.2),
('きゅうり',16,0.7,0.1,3.6,0.5),
('キャベツ',25,1.3,0.1,5.8,2.5),
('人参',41,0.9,0.2,10,2.8),
('ブロッコリー',34,2.8,0.4,7,2.6),
('豚肉ロース',242,27,14,0,0),
('牛肉赤身',250,26,15,0,0),
('サーモン',208,20,13,0,0),
('マグロ',144,23,5,0,0),
('じゃがいも',77,2,0.1,17,2.2),
('さつまいも',132,1.5,0.1,31,3),
('オートミール',389,17,7,66,11),
('コーンフレーク',357,8,1,84,3),
('りんご',52,0.3,0.2,14,2.4),
('みかん',53,0.8,0.3,13,1.8),
('もやし',30,3,0.2,6,2),
('豆腐',76,8,4,1.9,0.3),
('しいたけ',22,3,0.3,3.3,2.5),
('ほうれん草',23,2.9,0.4,3.6,2.2),
('なす',25,1,0.2,6,2);

-- meal_logs
DROP TABLE IF EXISTS meal_logs;
CREATE TABLE meal_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity FLOAT NOT NULL,
    eaten_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    meal_type ENUM('breakfast','lunch','dinner','snack') DEFAULT 'lunch',
    serving_size FLOAT DEFAULT 100,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES foods(id) ON DELETE CASCADE
);
INSERT INTO meal_logs (user_id, food_id, quantity, meal_type) VALUES
(1,1,150,'breakfast'),
(1,4,100,'breakfast'),
(1,3,120,'snack'),
(2,2,60,'breakfast'),
(2,16,120,'lunch'),
(2,20,150,'dinner'),
(3,5,100,'breakfast'),
(3,6,50,'lunch'),
(3,21,40,'snack');