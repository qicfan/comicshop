<?php
/**
 * 网站访问统计
 * @author johz
 */
 
 
require_once PRO_ROOT . 'models.php';

class statsViews{

	public static function index(){
			$from = htmlspecialchars($_GET['ref'],ENT_QUOTES);
			$visit = htmlspecialchars($_GET['lof'],ENT_QUOTES);
            $ip = real_ip();

            $log = $ip.','.date("Y-m-d H:i:s").','.$visit.','.$from."\n";

			$path = 'uploadfile/stats/'.date('Y',time()).'/'.date('m',time()).'/';
			if(!file_exists($path)){
				if(mkdir($path,0700,true)){
					$path = $path;
				}else{
					$path = 'uploadfile/stats/';
				}
			}

           $handle = fopen($path.'/'.date('Y-m-d',time()).'.txt','a+');
           fwrite($handle,$log);
		   fclose($handle);
	}

}


/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

?>