<?php

const DB_SERVER = 'localhost';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'aebo_web_db';
//connection to db
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$conn->set_charset("utf8");

if ($conn === false) {
    die("ERROR: Konnte nicht verbinden. " . mysqli_connect_error());
}
