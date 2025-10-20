<?php

$host = "localhost";
$user = "root";
$pass = "qwerty";
$db   = "showroom_mobil";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi) {
	die ("koneksi gagal");
}
