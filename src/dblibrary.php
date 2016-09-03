<?php

namespace dbLibrary;

class Database{

	public  $handler; 
	private $connectionSettings;
	private $configFile = __DIR__ . '/DBConfig/list.json';

	function __construct($connectionName){


		$this->getCongig($connectionName);
		$this->connect();
		
	}

	private function getCongig($connectionName){

		if (!$configJson = @file_get_contents($this->configFile)) {
		    
		    $error = error_get_last();
		    echo "File Reading Error (".$this->configFile.") <br/>";
		    die;

		}

		$configArray = @json_decode($configJson,true);

		if ($configArray==null){

			echo "File Format Error ( ".$this->configFile.") is not valid json) <br/>";
			die;
		}


		if (isset($configArray[$connectionName])) {

			$this->connectionSettings = $configArray[$connectionName];
			

		}else{

			echo "The given database name is not found in the congig file (".$this->configFile.") <br/>";
			die;
		}



	}

	private function connect(){

	 	/* Database Connaction */
	    try {

	    	$connectionSettingsString = 	$this->connectionSettings["engine"].':host='.$this->connectionSettings["host"].';dbname='.$this->connectionSettings["database"];

	        $this->handler = new PDO(
	        		$connectionSettingsString
	        		, $this->connectionSettings["username"]
	        		, $this->connectionSettings["password"]);

	        $this->handler ->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );    
	        
	    } catch (PDOException $e) {
	        print "Error!: " . $e->getMessage() . "<br/>";
	        die();
	    }

	}

	public function get( $sql, $params = []){

		try {
				$query_handler = $this->handler->prepare($sql);
                $query_result = $query_handler ->execute($params);
                
                return $query_handler->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

	}


	public function set( $sql, $params = []){

		try {
				$query_handler = $this->handler->prepare($sql);
                $query_result = $query_handler ->execute($params);
                return $query_result;
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

	}

}


/* Example

$db = New Database;
$db = New Database;
$db->set("INSERT INTO test (id, name) VALUES (?, ?)",["8","three"]);


$jobs = $db->get("select * from test");
var_dump($jobs);


*/

