<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../library/function.php";
include_once "../../library/create_image.php";

if (isset($_POST["del_name"])
    && isset($_POST["del_pwd"])
    && isset($_POST["del_mobile"])
	
	&& isset($_POST["del_note"])
	&& is_auth()
  
) {
  
     $del_name = $_POST["del_name"];
    $del_pwd = $_POST["del_pwd"];
	$del_mobile = $_POST["del_mobile"];

	$del_note = $_POST["del_note"] == null ?"" : $_POST["del_note"] ;
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


    $insertArray = array();
	
    array_push($insertArray, htmlspecialchars(strip_tags($del_name)));
    array_push($insertArray, htmlspecialchars(strip_tags($del_pwd)));
	array_push($insertArray, htmlspecialchars(strip_tags($del_mobile)));

    array_push($insertArray, htmlspecialchars(strip_tags($del_note)));
	
	  array_push($insertArray, htmlspecialchars(strip_tags($img_image)));
    array_push($insertArray, htmlspecialchars(strip_tags($img_thumbnail)));


    $sql = "insert into delivery
        (del_name , del_pwd ,
		del_mobile ,del_note ,		
		del_image , del_thumbnail
		, del_regdate )
            values(? , ? ,
			? , ? ,
			? , ? ,
			 now())";
    $result = dbExec($sql, $insertArray);


    $resJson = array("result" => "success", "code" => "200", "message" => "done");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
} else {
    //bad request
    $resJson = array("result" => "fail", "code" => "400", "message" => "error");
    echo json_encode($resJson, JSON_UNESCAPED_UNICODE);
}
