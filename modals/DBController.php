<?php

class DBController
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "product";

    // connection property
    public $con = null;

    // call constructor
    public function __construct()
    {
        try {
            $this->con = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch( PDOException $exception ) {
            echo "Connection error :" . $exception->getMessage();
        }
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    // for mysqli closing connection
    protected function closeConnection(){
        if ($this->con != null ){
            $this->con = null;
        }
    }

    /*
	* read from database
	*/
	public function read($query,$data = array())
	{

		$stm = $this->con->prepare($query);
		$result = $stm->execute($data);

		if($result){
			$data = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($data) && count($data) > 0)
			{
				return $data;
			}
		}

		return false;
	}

	/*
	* write to database
	*/
	public function write($query,$data = array())
	{

		$stm = $this->con->prepare($query);
		$result = $stm->execute($data);

		if($result){
			 
			return true;
 		}

		return false;
	}
    /*
	* read from database to count
	*/
    public function read_count($query,$data = array())
	{

		$stm = $this->con->prepare($query);
		$result = $stm->execute($data);

		if($result){
			$data = $stm->fetchAll(PDO::FETCH_OBJ);
			if(is_array($data))
			{
                $count = count($data);
				return $count;
			}
		}

		return false;
	}
}