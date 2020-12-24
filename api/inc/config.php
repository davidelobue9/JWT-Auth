<?php

define('DATABASE', 
	   array(
			'hostname'=>'localhost',
			'name'=>'name',
			'username'=>'username',
			'password'=>'password'
			)
	  );

define('JWT', 
	   array(
			'key'=>'LP9kyaPfcD9buxqH',
			'issuer'=>'issuer',
			'audience'=>'audience',
			'issuedAt'=>time(),
			'notBefore'=>0,
			'expiration'=>time()+60
			)
	  );


?>