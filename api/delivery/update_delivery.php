<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
include_once "../../library/create_image.php";
if (
    isset($_POST["del_id"])
    && is_numeric($_POST["del_id"])
    && isset($_POST["del_name"])
    && isset($_POST["del_pwd"])
    && isset($_POST["del_mobile"])	
			 && isset($_POST["del_note"])
    
    && is_auth()
) {
		if (!empty($_FILES["file"]['name']) )
	{
		$images = uploadImage("file" , '../../images/delivery/' , 200 , 600);
		$img_image = $images["image"];
		$img_thumbnail = $images["thumbnail"];
    
	}
	else
	{
		$img_image = "";
		$img_thumbnail = "";
	}

	
    $del_name = $_POST["del_name"];
    $del_pwd = $_POST["del_pwd"];
	$del_mobile = $_POST["del_mobile"];
	
    
	$del_note = $_POST["del_note"] == null ?"" : $_POST["del_note"] ;
    
   
    $del_id = $_POST["del_id"];

    $updateArray = array();
    array_push($updateArray, htmlspecialchars(strip_tags($del_name)));
    array_push($updateArray, htmlspecialchars(strip_tags($del_pwd)));
	array_push($updateArray, htmlspecialchars(strip_tags($del_mobile)));   	
    array_push($updateArray, htmlspecialchars(strip_tags($del_note)));
	if($img_image != "")
	{
		array_push($updateArray, htmlspecialchars(strip_tags($img_image)));
		array_push($updateArray, htmlspecialchars(strip_tags($img_thumbnail)));
	}
    array_push($updateArray, htmlspecialchars(strip_tags($del_id)));

	if($img_image != "")
	{
		$sql = "update delivery 
		set del_name=?,del_pwd=?,
		set del_mobile=?,del_note=?,
		del_image = ? , del_thumbnail = ? 
		where del_id=?";
	}
	else
	{
			$sql = "update food 
		set del_name=?,del_pwd=?,
		set del_mobile=?,del_note=?
		
		
		where del_id=?";
	}
    $result = dbExec($sql, $updateArray);


    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
