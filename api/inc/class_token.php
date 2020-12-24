<?php

include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

class Token{
	
	private $cKey;
	private $token;
	
	public function __construct()
	{
		$a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }
	
	public function __construct2($jwt, $key)
	{
		$this->cKey = $key;
		$this->token = JWT::decode($jwt, $key, array('HS256'));
    }
	public function __construct7($key, $issuer, $audience, $issuedAt, $notBefore, $expiration, $data)
	{
		
		$this->cKey = $key;
		
		$this->token = (object)[
		   	"iss" => $issuer,
		   	"aud" => $audience,
			"iat" => $issuedAt,
			"nbf" => $notBefore,
		   	"exp" => $expiration,
			"data" => $data
		];
		
    }
	
	public function getIssuer()
	{
		return $this->token->iss;
	}
	public function getAudience()
	{
		return $this->token->aud;
	}
	public function getIssuedAt()
	{
		return $this->token->iat;
	}
	public function getNotBefore()
	{
		return $this->token->nbf;
	}
	public function getExpiration()
	{
		return $this->token->exp;
	}
	public function getData()
	{
		return $this->token->data;
	}
		
	public function getEncoded()
	{
		return JWT::encode($this->token, $this->cKey);
	}
	
	public static function validate($jwt, $key)
	{
		return JWT::decode($jwt, $key, array('HS256'));
	}
	
}



?>