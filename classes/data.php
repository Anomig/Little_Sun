<?php
abstract class Data {
    private static $conn;

    public static function getConnection() {
        if (self::$conn == null) {
            self::$conn = new PDO('mysql:host=localhost;dbname=little_sun', 'root', 'root');
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}


