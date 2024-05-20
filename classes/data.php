<?php
abstract class Data {
    private static $conn;

    public static function getConnection() {
        if (self::$conn == null) {
            // self::$conn = new PDO('mysql:host=ID436930_littlesun.db.webhosting.be;dbname=ID436930_littlesun', 'ID436930_littlesun', 'Little_Sun1234');
            // self::$conn = new PDO('mysql:host=ID436930_llittlesun.db.webhosting.be;dbname=ID436930_llittlesun', 'ID436930_llittlesun', 'root');
            self::$conn = new PDO('mysql:host=localhost;dbname=little_sun', 'root', 'root');
            
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Verbinding met de database is gelukt!";
        }
        return self::$conn;
        echo 'error';
    }
}


