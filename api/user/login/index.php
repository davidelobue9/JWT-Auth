<?php

header("Access-Control-Allow-Origin: https://oopus.net/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../../inc/class_user.php");

$data = json_decode(file_get_contents("php://input"));

try
{
	$user = new User($data->username, $data->password);
}
catch(PDOException $e)
{
	echo $e->getMessage();
}

try
{
	
	$token = $user->authenticate();
	echo json_encode(
			array(
				"message" => "Successful authentication.",
				"jwt" => $token,
				"data" => 
					array(
							"uid" => $user->getId(),
							"username" => $user->getUsername(),
							"email" => $user->getEmail(),
							"avatar" => $user->getAvatar(),
							"avatardimensions" => $user->getAvatarDimensions(),
							"usergroup" => $user->getUserGroup()
					)
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


	
?>