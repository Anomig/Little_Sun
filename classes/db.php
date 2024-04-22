<?php
    
    abstract class Db{

        private static $conn;

        public static function getConnection(){
            if(self::$conn ==null){
                //echo '💪';
                self::$conn = new PDO('mysql:host=localhost;dbname=littlesun', "root", "root");
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$conn;
            }
            else{
                return self::$conn;
            }
        }
        
    }

