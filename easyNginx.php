<?php 
/**
* (c) Ayat Maulana 2016
* Simple Nginx VHost Creator
*/

if (isset($_SERVER['REMOTE_ADDR'])) die('Permission Denied');

class NginxVhostCreator
{
	
	public function __construct()
	{
		print_r($this->getConfigData());
	}

	public function getConfigData(){
		$word = ['server','port','path','php'];
		$data = [];
		for ($i=0; $i < count($word); $i++) { 

			try {
				$handle = fopen('php://stdin', 'r');
				echo $word[$i]." : ";
				$line = fgets($handle);
				switch ($word[$i]) {
					case 'server':
						if (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $line)) {
							$data[$word[$i]] = $line;
						}
						else{
							die('Name Server Invalid');
						}

						break;
				}

			} catch (Exception $e) {
				die($e->getMessage());	
			}

		}

		return $data;
	}

	public function makeFileConfig(){
	}
}



$show = "\tSimplify Your Life :) \n";
$show .= "\t----------------------\n";
$show .= "\tEasy Nginx Vhost Config\n";
$show .= "\t(c) Ayat Maulana 2016\n\n";

echo $show;
(new NginxVhostCreator());