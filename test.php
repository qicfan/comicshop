<?php
//$arr = file("./uploadfile/stats/2010/07/2010-07-09.txt");
//print_r($arr);

//$logfile = "./uploadfile/stats/".date("Y").'/'.date("m").'/'.date("Y-m-d").".txt";

//$handle = @fopen($logfile, "r");

//if ($handle) {
  //  while (!feof($handle)) {
 //       $buffer = fgets($handle);
 //       echo $buffer.'<br/>';
 //   }
//    fclose($handle);
//}

function writefile($file, $pid){
	static $count;
		$count++;
		echo "call writefile, pid={$pid},count={$count}\n";
		while(1){
			$fp = fopen($file, "a+");
			if(!$fp){
				continue;
			}
			break;
		}
		while(1){	 
		   if(!flock($fp, LOCK_EX)){
					continue;
				}
				fwrite($fp,"PID: $pid\tTest contents".$count."\n");
				flock($fp, LOCK_UN);
				fclose($fp);
				break;
		}
		return;
}

echo "Start ...\n";
@unlink('./fork_test3.txt');
for($i=0; $i<5; $i++){
  $pid = pcntl_fork();
    switch($pid){
        case -1: die('fork error');
		break;
        case 0: writefile("./fork_test3.txt",posix_getpid());
		break;
        default: pcntl_wait($status);
		exit;
	}
}


/** 
* safe_file_put_contents() һ������ɴ��ļ���д�����ݣ��ر��ļ������������ȷ��д��ʱ������ɲ�����ͻ
* 
* @param string $filename 
* @param string $content 
* @param int $flag 
* 
* @return boolean 
**/ 
	function safe_file_put_contents($filename, & $content) {
		$fp = fopen($filename, 'wb');
		if ($fp) { 
			flock($fp, LOCK_EX); 
			fwrite($fp, $content); 
			flock($fp, LOCK_UN); 
			fclose($fp); 
			return true; 
		} else {
			return false;
		} 
    }
	/** 
	* safe_file_get_contents() �ù�����ģʽ���ļ�����ȡ���ݣ����Ա����ڲ���д����ɵĶ�ȡ���������� 
	* 
	* @param string $filename 
	*
	* @return mixed
	*/ 
	function safe_file_get_contents($filename){ 
	    $fp = fopen($filename, 'rb');
		if ($fp) { 
			flock($fp, LOCK_SH); 
			clearstatcache();
			$filesize = filesize($filename);
			if ($filesize > 0) {
				$data = fread($fp, $filesize); 
			} else { 
				$data = false; 
			} 
			flock($fp, LOCK_UN); 
			fclose($fp); 
			return $data; 
		} else { 
			return false; 
		}
	}

?>