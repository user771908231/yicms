<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/10/19
 * Time: 14:12
 */

namespace App\Console;

/**
 * Class PublicFunction 公共方法函数类
 * User: company_windows_locahost_wm
 * Date: 2018/10/19
 * Time: 14:14
 * @package App\Console
 */
class PublicFunction
{
    /**
     * @Title : Sec2Time
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/10/19
     * @Time  : 14:15
     * @param int $time
     * @return bool|string
     */
    public static function Sec2Time(int $time){
        if(is_numeric($time)){
            $value = array(
                "years" => 0, "days" => 0, "hours" => 0,
                "minutes" => 0, "seconds" => 0,
            );
            if($time >= 31556926){
                $value["years"] = floor($time/31556926);
                $time = ($time%31556926);
            }
            if($time >= 86400){
                $value["days"] = floor($time/86400);
                $time = ($time%86400);
            }
            if($time >= 3600){
                $value["hours"] = floor($time/3600);
                $time = ($time%3600);
            }
            if($time >= 60){
                $value["minutes"] = floor($time/60);
                $time = ($time%60);
            }
            $value["seconds"] = floor($time);
            //return (array) $value;
//            $t = '';
            if ($value["years"])
            {
                Return $value["years"] ."年". $value["days"] ."天"." ". $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
            }elseif ($value["days"]){
                Return $value["days"] ."天"." ". $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
            }elseif ($value["hours"]){
                Return $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
            }elseif ($value["minutes"]){
                Return $value["minutes"] ."分".$value["seconds"]."秒";
            }
            Return$value["seconds"]."秒";
//            Return $t;

        }else{
            return (bool) FALSE;
        }
    }

    public static function ConversionTime(int $time){
        if(is_numeric($time)){
            return mb_substr($time,0,4).'-'.mb_substr($time,4,2).'-'.mb_substr($time,6);
        }
        else{

            }
    }

    /**
     * @Title : explodeString
     * @User  : company_windows_locahost_wm
     * @Date  : 2018/11/8
     * @Time  : 15:17
     * @param string $string
     * @param string $int
     * @return string
     */
    public static function explodeString(string $string,string $int):string
    {
        $arr = explode(',',$string);
        $key=array_search(10000 ,$arr);
        array_splice($arr,$key,1);
        return implode(",", $arr);
    }
    
    public static function building($num_str,$type)
    {
        $len=strlen($num_str);
        $b = "";
        switch ($type){
            case 1:
                switch ($len){
                    case 1:
                        $b = "0".$num_str;
                        break;
                    case 2:
                        $b = $num_str;
                        break;
                }
                return $b."单元";
                break;
            case 2:
                switch ($len){
                    case 1:
                        $b="000".$num_str;
                        break;
                    case 2:
                        $b ="00".$num_str;
                        break;
                    case 3:
                        $b = "0".$num_str;
                        break;
                    case 4:
                        $b = $num_str;
                        break;
                }
                return $b."号";
                break;
            default:
                switch ($len){
                    case 1:
                        $b="00".$num_str;
                        break;
                    case 2:
                        $b ="0".$num_str;
                        break;
                    case 3:
                        $b = $num_str;
                        break;
                }
                return $b."栋";
                break;
        }
    }

    public static function building($num_str,$type)
    {
        $len=strlen($num_str);
        $b = "";
        switch ($type){
            case 1:
                switch ($len){
                    case 1:
                        $b = "0".$num_str;
                        break;
                    case 2:
                        $b = $num_str;
                        break;
                }
                return $b."单元";
                break;
            case 2:
                switch ($len){
                    case 1:
                        $b="000".$num_str;
                        break;
                    case 2:
                        $b ="00".$num_str;
                        break;
                    case 3:
                        $b = "0".$num_str;
                        break;
                    case 4:
                        $b = $num_str;
                        break;
                }
                return $b."号";
                break;
            default:
                switch ($len){
                    case 1:
                        $b="00".$num_str;
                        break;
                    case 2:
                        $b ="0".$num_str;
                        break;
                    case 3:
                        $b = $num_str;
                        break;
                }
                return $b."栋";
                break;
        }
    }

}