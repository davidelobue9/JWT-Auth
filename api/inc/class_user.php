<?php

include("config.php");
include("class_database.php");
include("class_token.php");

class InvalidLoginException extends Exception {};

class User
{
	
	private $database;
	private $token = null;
	
	private $username;
	private $clearPassword;
	
	private $userData = null;
	
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->clearPassword = $password;
		try
		{
			$this->database = $this->createDatabase();
		}
		catch(PDOException $exception)
		{
			throw $exception;
		}
	}
	
	public function getId()
	{
		if($this->userData != null)
		{
			return $this->userData['uid'];
		}
	}
	public function getUsername()
	{
		if($this->userData != null)
		{
			return $this->userData['username'];
		}
	}
	public function getEmail()
	{
		if($this->userData != null)
		{
			return $this->userData['email'];
		}
	}
	public function getAvatar()
	{
		if($this->userData != null)
		{
			return $this->userData['avatar'];
		}
	}
	public function getAvatarDimensions()
	{
		if($this->userData != null)
		{
			return $this->userData['avatardimensions'];
		}
	}
	public function getUserGroup()
	{
		if($this->userData != null)
		{
			return $this->userData['usergroup'];
		}
	}
	
	public function authenticate()
	{
		
		$query = "SELECT * FROM users WHERE username = '".$this->username."'";
		$userData = $this->database->query($query);
		
		if($userData['password'] == User::saltPassword($this->clearPassword, $userData['salt']))
		{
			$this->userData = $userData;
		}
		else
		{
			throw new InvalidLoginException();
		}
		
		$tokenData = array(
			"uid" => $userData['uid'],
			"username" => $userData['username'],
			"password" => $this->clearPassword
		);
		
		$this->token = new Token(
			JWT['key'],
			JWT['issuer'],
			JWT['audience'],
			JWT['issuedAt'],
			JWT['notBefore'],
			JWT['expiration'],
			$tokenData
		);
		
		return($this->token->getEncoded());
		
	}
	
	private function createDatabase()
	{
		try
		{
			$database = new Database(
				DATABASE['hostname'], 
				DATABASE['name'], 
				DATABASE['username'], 
				DATABASE['password']
			);
		}
		catch(PDOException $exception)
		{
			throw $exception;
		}
		
		return $database;
		
	}
	
	public static function saltPassword($password, $salt)
	{
		return md5(md5($salt).md5($password));
	}

	
}

?>
