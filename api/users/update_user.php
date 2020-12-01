<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
if (
    isset($_POST["use_id"])
    && is_numeric($_POST["use_id"])
    && isset($_POST["use_name"])
    && isset($_POST["use_pwd"])
    && isset($_POST["use_mobile"])
    && is_auth()
) {
    $use_name = $_POST["use_name"];
    $use_pwd = $_POST["use_pwd"];
    $use_mobile = $_POST["use_mobile"];
    $use_active = isset($_POST["use_active"]) ? $_POST["use_active"] : "0";
    $use_note = isset($_POST["use_note"]) ? $_POST["use_note"] : "";
    $use_id = $_POST["use_id"];

    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($use_name)));
    array_push($updateArray, htmlspecialchars(strip_tags($use_pwd)));
    array_push($updateArray, htmlspecialchars(strip_tags($use_mobile)));
    array_push($updateArray, htmlspecialchars(strip_tags($use_active)));
    array_push($updateArray, htmlspecialchars(strip_tags($use_note)));
    array_push($updateArray, htmlspecialchars(strip_tags($use_id)));

    $sql = "update users 
    set use_name=?,use_pwd=?,use_mobile=?,use_active=?,use_note=?,use_lastdate=now()
    where use_id=?";
    $result = dbExec($sql, $updateArray);


    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
