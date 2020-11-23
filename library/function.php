<?php
include_once "database.php";

function dbExec($sql, $param_array)
{
    $database = new Database();
    $database->getConnection();
    $myCon = $database->conn;
    $stmt = $myCon->prepare($sql);
    $stmt->execute($param_array);
    return $stmt;
}
