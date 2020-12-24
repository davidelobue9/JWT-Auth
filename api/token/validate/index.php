<?php

header("Access-Control-Allow-Origin: https://oopus.net/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../../inc/config.php");
include("../../inc/class_user.php");

$data = json_decode(file_get_contents("php://input"));

try
{
	
	$token = new Token($data->jwt, JWT['key']);
	$userData = $token->getData();

	try
	{
		$user = new User($userData->username, $userData->password);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}

	try
	{

		$tokenNew = $user->authenticate();
		echo json_encode(
				array(
					"message" => "Successful authentication.",
					"jwt" => $tokenNew
				)
			);

	}
	catch(InvalidLoginException $e)
	{
		http_response_code(401);
		echo json_encode(
				array(
					"message" => "Authentication failed."
				)
			);

	}

	http_response_code(200);
	
}
catch(Exception $e)
{
	
	http_response_code(401);
	
	echo json_encode(
		array(
			"message" => $e->getMessage()
		)
	);
	
}
	
?>