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

	public function getConfigData()
	{
		$word = ['server','port','path'];
		$data = [];
		for ($i=0; $i < count($word); $i++) { 

			try {
				$handle = fopen('php://stdin', 'r');
				echo $this->color(strtoupper($word[$i]." : "),"l_green");
				$line = fgets($handle);
				switch ($word[$i]) {
					case 'server':
						if (preg_match("/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/", $line)) {
							$data[$word[$i]] = $line;
						}
						else{
							die($this->color("Name Server Invalid !!!!!!!!!\n","l_red"));
						}

						break;

					case 'port':
						if (preg_match("/^[0-9]{2,4}$/",$line)) {
							$data[$word[$i]] = $line;
						}
						else{
							die($this->color("Port Invalid !!!!!!!!!\n","l_red"));
						}

						break;

					case 'path':
						if (preg_match("/\/{1}([a-z0-9-])(.*)/",$line)) {
							$data[$word[$i]] = $line;
						}
						else
						{
							die($this->color("Path Invalid !!!!!!!!!\n","l_red"));
						}
				}
				unset($line);

			} catch (Exception $e) {
				die($e->getMessage());	
			}

		}

		$this->datanya = $data;

		return;
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
		            try_files ".'\$'."uri ".'\$'."uri/ /index.php?$query_string;
		    }";

		$config .= "
			# pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
			#
			location ~ \.php$ {
				try_files $uri /index.php =404;
				fastcgi_split_path_info ^(.+\.php)(/.+)$;
			#
			#	# With php5-cgi alone:
			#	fastcgi_pass 127.0.0.1:9000;
			#	# With php7.1-fpm:
				fastcgi_pass unix:/run/php/php7.1-fpm.sock;
				fastcgi_index index.php;
				fastcgi_pparam SCRIPT_FILENAME $document_root$fastcgi_script_name;
				include fastcgi_params;
			}
		}";

		exec("echo \"".$config."\" > ~/".trim($this->datanya['server']));
		exec("sudo mv ~/". trim($this->datanya['server'])."  /etc/nginx/sites-enabled/".$this->datanya['server']);
		exec("sudo ln -s /etc/nginx/sites-enabled/".trim($this->datanya['server'])." /etc/nginx/sites-available"); 
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

function warnai($string, $fontcolor){
	return NginxVhostCreator::color($string, $fontcolor);
}


echo "\n\n". 
warnai("\t _, _  _, _ _, _ _  ,   _,_ _,_  _,  _, ___   _, _  _, _,_ __, __,","l_red")."\n".
warnai("\t |\ | / _ | |\ | '\/    | / |_| / \ (_   |    |\/| /_\ |_/ |_  |_)","l_red")."\n".
warnai("\t | \| \ / | | \|  /\    |/  | | \ / , )  |    |  | | | | \ |   | \\","white")."\n".
warnai("\t ~  ~  ~  ~ ~  ~ ~  ~   ~   ~ ~  ~   ~   ~    ~  ~ ~ ~ ~ ~ ~~~ ~ ~","white")."\n".
warnai("\t Simplify Your Life :)","white")."                       ".warnai("(c)","yellow").warnai(" AyatMaulana ","l_red").warnai("2016","l_blue")."\n\n";

(new NginxVhostCreator());

