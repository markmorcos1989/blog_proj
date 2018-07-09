<?php
// Create connection

//$conn = new mysqli($servername, $username, $password);
$conn = new mysqli('localhost', 'root', '');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$db = "CREATE DATABASE myDB";
if ($conn->query($db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error."<br>";
}

// Create connection to DB

//$conn = new mysqli($servername, $username, $password, $dbname);
$conn2 = new mysqli('localhost', 'root', '', 'myDB') or die('error with connection');
// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error."<br>");
} 

//create tables

$users_table = "CREATE TABLE users (
user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
firstname VARCHAR(255) NOT NULL,
lastname VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
email_code VARCHAR(255) NOT NULL,
active INT(6) NOT NULL DEFAULT '0',
profile_pic VARCHAR(255) NOT NULL,
date_created DATETIME DEFAULT NOT NULL,
date_updated DATETIME DEFAULT NOT NULL
)";

if ($conn2->query($users_table) === TRUE) {
    echo "Table users created successfully<br>";
} else {
    echo "Error creating users table: " . $conn2->error."<br>";
}

$posts_table = "CREATE TABLE posts (
post_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id INT(6) NOT NULL,
username VARCHAR(255) NOT NULL,
title VARCHAR(1000) NOT NULL,
image VARCHAR(255) NOT NULL
post text(1000) NOT NULL,
date_created DATETIME NOT NULL,
date_updated DATETIME NOT NULL
)";

if ($conn2->query($posts_table) === TRUE) {
    echo "Table posts created successfully<br>";
} else {
    echo "Error creating posts table: " . $conn2->error."<br>";
}

$comments_table = "CREATE TABLE comments (
comment_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id INT(6) NOT NULL,
title VARCHAR(1000) NOT NULL, 
comment text(1000) NOT NULL,
post_id INT(6) NOT NULL,
username VARCHAR(1000) NOT NULL,
date_created DATETIME  NOT NULL,
date_updated DATETIME  NOT NULL
)";

if ($conn2->query($comments_table) === TRUE) {
    echo "Table comments created successfully<br>";
} else {
    echo "Error creating comments table: " . $conn2->error."<br>";
}

//altering tables

/*$alter_users_table = "ALTER TABLE users
MODIFY COLUMN date_created DATETIME NOT NULL,
MODIFY COLUMN date_updated DATETIME NOT NULL";

if ($conn2->query($alter_users_table) === TRUE) {
    echo "Table users altered successfully<br>";
} else {
    echo "Error altering users table: " . $conn2->error."<br>";
}

$alter_posts_table = "ALTER TABLE posts
MODIFY COLUMN date_created DATETIME NOT NULL,
MODIFY COLUMN date_updated DATETIME NOT NULL";

if ($conn2->query($alter_posts_table) === TRUE) {
    echo "Table posts altered successfully<br>";
} else {
    echo "Error altering posts table: " . $conn2->error."<br>";
}

$alter_comments_table = "ALTER TABLE comments
MODIFY COLUMN date_created DATETIME NOT NULL,
MODIFY COLUMN date_updated DATETIME NOT NULL";

if ($conn2->query($alter_comments_table) === TRUE) {
    echo "Table comments altered successfully<br>";
} else {
    echo "Error altering comments table: " . $conn2->error."<br>";
}

//add columns to table

$add_posts_table = "ALTER TABLE posts 
ADD image VARCHAR(255) NOT NULL after title";

if ($conn2->query($add_posts_table) === TRUE) {
    echo "column added to Table posts successfully<br>";
} else {
    echo "Error adding to posts table: " . $conn2->error."<br>";
}

$add_comments_table = "ALTER TABLE comments ADD user_id INT(6) NOT NULL after comment_id";

if ($conn2->query($add_comments_table) === TRUE) {
    echo "column added to Table comments successfully<br>";
} else {
    echo "Error adding to comments table: " . $conn2->error."<br>";
}*/

//closing conn

$conn->close();
?>
<!--reg_date TIMESTAMP-->