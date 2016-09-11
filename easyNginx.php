<?php 
/**
* (c) Ayat Maulana 2016
* Simple Nginx VHost Creator
*/

if (isset($_SERVER['REMOTE_ADDR'])) die('Permission Denied CLI Only :)');

class NginxVhostCreator
{
	public $datanya;
	
	public function __construct()
	{
		$this->getConfigData();
		$this->makeFileConfig();
	}

	public function getConfigData(){
		$word = ['server','port','path'];
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

	public function makeFileConfig(){

		$config = "server {
			listen ".trim($this->datanya['port']).";

			root ".trim($this->datanya['path']).";
			index index.php index.html index.htm ;

			# Make site accessible from http://localhost/
			server_name ".trim($this->datanya['server']).";


		    location ~* \.(ico|css|js|gif|jpe?g|png)(\?[0-9]+)?$ {
	            expires max;
	            log_not_found off;
		    }
		    
		    location / {
		            # Check if a file or directory index file exists, else route it to index.php.
		            try_files ".'\$'."uri ".'\$'."uri/ /index.php;
		    }";

		$config .= "
			# pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
			#
			location ~ \.php$ {
				fastcgi_split_path_info ^(.+\.php)(/.+)$;
			#
			#	# With php5-cgi alone:
			#	fastcgi_pass 127.0.0.1:9000;
			#	# With php5-fpm:
				fastcgi_pass unix:/var/run/php5-fpm.sock;
				fastcgi_index index.php;
				include fastcgi_params;
			}
		}";

		exec("echo \"".$config."\" > ~/".trim($this->datanya['server']));
		exec("sudo mv ~/". trim($this->datanya['server'])."  /etc/nginx/sites-enabled/".$this->datanya['server']);
		exec("sudo ln -s /etc/nginx/sites-enabled/".trim($this->datanya['server'])." /etc/nginx/sites-avaible"); 
		exec("sudo nginx -t");
		exec("sudo service nginx restart");

		return;
	}


	public static function color($string, $fontColor=NULL) {
		switch ($fontColor) {
			case 'black' : $color = '0;30'; break;
			case 'dark_gray' : $color = '1;30'; break;
			case 'blue' : $color = '0;34'; break;
			case 'l_blue' : $color = '1;34'; break;
			case 'green' : $color = '0;32'; break;
			case 'l_green' : $color = '1;32'; break;
			case 'cyan' : $color = '0;36'; break;
			case 'l_cyan' : $color = '0;36'; break;
			case 'red' : $color = '0;31'; break;
			case 'l_red' : $color = '1;31'; break;
			case 'purple' : $color = '0;35'; break;
			case 'l_purple' : $color = '1;35'; break;
			case 'brown' : $color = '0;33'; break;
			case 'yellow' : $color = '1;33'; break;
			case 'l_gray' : $color = '0;37'; break;
			case 'white' : $color = '1;37'; break;
		}
		$colored_string = "";
		$colored_string .= "\033[" . $color . "m";
		$colored_string .=  $string . "\033[0m";
		return $colored_string;
	}
}



$show = "\t".NginxVhostCreator::color("Simplify Your Life :)","yellow")."\n";
$show .= "\t".NginxVhostCreator::color("--------------------","red")."\n";
$show .= "\t".NginxVhostCreator::color("Easy Nginx Vhost Config Maker","l_blue")."\n";
$show .= "\t".NginxVhostCreator::color("(c) Ayat Maulana 2016","l_blue")."\n\n";

echo $show;
(new NginxVhostCreator());