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


class Data
{
    private static $conn;

    public static function getConnection()
    {
        if (self::$conn === null) {
            // 1) Render macro: DB_URL = mysql://user:pass@host:3306/dbname
            $url = getenv('DB_URL');
            if ($url) {
                $p = parse_url($url);
                $host = $p['host'] ?? 'localhost';
                $port = $p['port'] ?? '3306';
                $user = $p['user'] ?? '';
                $pass = $p['pass'] ?? '';
                $name = ltrim($p['path'] ?? '', '/');
            } else {
                // 2) Lokaal fallback (MAMP)
                $host = getenv('DB_HOST') ?: 'localhost';
                $port = getenv('DB_PORT') ?: '3306';
                $name = getenv('DB_NAME') ?: 'little_sun';
                $user = getenv('DB_USER') ?: 'root';
                $pass = getenv('DB_PASS') ?: 'root';
            }

            $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
            self::$conn = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$conn;
    }
}
