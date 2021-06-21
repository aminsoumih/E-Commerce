<?php
// normalize edge cases
function normalize(array $array, string $index, $default)
{
    return isset($array[$index]) && $array[$index] ? $array[$index] : $default;
}

// get connection to database
function getDbConnection(string $host, string $username, string $password)
{
    // connect to db
    try {
        $db = new PDO("mysql:host=$host;dbname=boutique", $username, $password);
        // raise PDO exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        return $e;
    }

    return $db;
}