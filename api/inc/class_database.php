<?php

class Database{

    private $host;
    private $name;
    private $username;
    private $password;
	
    private $connection = null;
 
	public function __construct($host, $name, $username, $password) 
	{
		
        $this->host = $host;
		$this->name = $name;
		$this->username = $username;
		$this->password = $password;
		
		try
		{		
			$this->connect();
		}
		catch(PDOException $exception)
		{
			throw $exception;
		}

    }
	
	public function query($query)
	{

		$row = null;
		
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() > 0)
		{
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		return $row;

	}
	
    public function getConnection()
	{
		
        if($this->connection == null)
		{
			try
			{
				$this->Connect();
			}
			catch(PDOException $exception)
			{
				throw $exception;
			}
		}
		
		return $this->connection;
		
	}
	
	private function connect()
	{
		
		try
		{
			$this->connection = new PDO("mysql:host=".$this->host.";dbname=" . $this->name, $this->username, $this->password);
		}
		catch(PDOException $exception)
		{
			throw $exception;
		}
	}
	
}

?>