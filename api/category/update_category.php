<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
if (
    isset($_POST["cat_id"])
    && is_numeric($_POST["cat_id"])
    && isset($_POST["cat_name"])
    && isset($_POST["cat_name_en"])
    
    && is_auth()
) {
    $cat_name = $_POST["cat_name"];
    $cat_name_en = $_POST["cat_name_en"];
   
    $cat_id = $_POST["cat_id"];

    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($cat_name)));
    array_push($updateArray, htmlspecialchars(strip_tags($cat_name_en)));
    array_push($updateArray, htmlspecialchars(strip_tags($cat_id)));

    $sql = "update category 
    set cat_name=?,cat_name_en=?,cat_regdate=now()
    where cat_id=?";
    $result = dbExec($sql, $updateArray);


    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
