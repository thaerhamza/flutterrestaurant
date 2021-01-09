<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
/*$images = uploadCustomerImage("file", '../../images/customer/' , 400 , 600 );
	$img_image = $images['image'];
	$img_thumbnail  = $images['thumbnail'];*/
if (
    isset($_POST["cat_name"])
    && isset($_POST["cat_name_en"])
    
    && is_auth()
) {
    $cat_name = $_POST["cat_name"];
    $cat_name_en = $_POST["cat_name_en"];
    


    $insertArray = array();
    array_push($insertArray, htmlspecialchars(strip_tags($cat_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($cat_name_en)));


    $sql = "insert into category
        (cat_name , cat_name_en , cat_regdate )
            values(? , ? , now())";
    $result = dbExec($sql, $insertArray);


    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
