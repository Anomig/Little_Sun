<?php
// abstract class Data
// {
//     private static $conn;

//     public static function getConnection()
//     {
//         if (self::$conn == null) {
//             self::$conn = new PDO('mysql:host=ID436930_littlesun.db.webhosting.be;dbname=ID436930_littlesun', 'ID436930_littlesun', 'Little_Sun1234');
//             // self::$conn = new PDO('mysql:host=ID436930_llittlesun.db.webhosting.be;dbname=ID436930_llittlesun', 'ID436930_llittlesun', 'root');
//             // self::$conn = new PDO('mysql:host=localhost;dbname=little_sun', 'root', 'root');

//             self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//             // echo "Verbinding met de database is gelukt!";
//         }
//         return self::$conn;
//         echo 'error';
//     }
// }

abstract class Db
{
    private static $db;

    public static function getConnection()
    {
        if (!self::$db) {
            // PROD (Render) leest uit ENV, lokaal valt hij terug op je MAMP waarden
            $host = getenv('DB_HOST') ?: 'localhost';
            $port = getenv('DB_PORT') ?: '3306';
            $name = getenv('DB_NAME') ?: 'lab2';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: 'root';

            $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
            self::$db = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$db;
    }
}
