<?php
    $database_hostname = "localhost";
    $database_username = "id21790036_ireniusbonan";
    $database_password = "Bonan@347";
    $database_name = "id21790036_news_cetalog";
    $database_port = 3306;

    try {
        $database_connection = new PDO("mysql:host=$database_hostname;port=$database_port;dbname=$database_name",
        $database_username, $database_password);
        $database_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Koneksi Berhasil";
    } catch (PDOException $x) {
        die("Koneksi Gagal: " . $x->getMessage());
    }
?>