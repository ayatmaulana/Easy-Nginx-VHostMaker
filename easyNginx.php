<?php 
/**
* (c) Ayat Maulana 2016
* Simple Nginx VHost Creator
*/

if (isset($_SERVER['REMOTE_ADDR'])) die('Permission Denied');

class NginxVhostCreator
{
	public $datanya;
	
	public function __construct()
	{
		$this->getConfigData();
		$this->makeFileConfig();
	}

	public function getConfigData(){
		$word = ['server','port','path','htaccess'];
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

					case 'port':
						if (preg_match("/^[0-9]{2,4}$/",$line)) {
							$data[$word[$i]] = $line;
						}
						else{
							die('Port Invalid');
						}

						break;

					case 'path':
						if (preg_match("/\/{1}([a-z0-9-])(.*)/",$line)) {
							$data[$word[$i]] = $line;
						}
						else
						{
							die('Path Invalid');
						}
				}
				unset($line);

			} catch (Exception $e) {
				die($e->getMessage());	
			}

		}

		$this->datanya = $data;

		return $data;
	}
}



$show = "\tSimplify Your Life :) \n";
$show .= "\t----------------------\n";
$show .= "\tEasy Nginx Vhost Config Maker\n";
$show .= "\t(c) Ayat Maulana 2016\n\n";

echo $show;
(new NginxVhostCreator());