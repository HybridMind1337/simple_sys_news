<?php
/**
 *
 * @Project: News sys
 * @Author HybridMind <www.webocean.info>
 * @Version: 0.0.1
 * @File config.php
 * @Created 29.1.2021 г.
 * @License: MIT
 * @Discord: HybridMind#6095
 *
 */

if (count(get_included_files()) == 1) {
    header("Location: index.php");
    exit;
}

error_reporting(E_ALL);
session_start();

$host = "localhost";
$root = "testing";
$pass = "testing";
$user = "testing";

$conn = mysqli_connect($host, $root, $pass, $user);

if ($conn) {
    mysqli_set_charset($conn, "UTF8");
} else {
    exit(PHP_EOL);
}


$forumPath = "./forums/"; // Пътя до форума