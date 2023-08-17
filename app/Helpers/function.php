<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/12
 * Time: 13:08
 */
if (!function_exists('prompt')) {

    //提示处理
    function prompt($message, $status = 'success')
    {
        $data = [
            'status' => $status,
            'message' => $message
        ];
        return response($data);
    }

}


if (!function_exists('sort_article_time')) {
    /**
     * 生成文章时间
     * @param $time
     * @return bool|string
     */
    function sort_article_time($time)
    {
        $now = time();
        if ($now - $time <= 60) {
            return '刚刚';
        } elseif ($now - $time < 3600) {
            return floor(($now - $time) / 60) . '分钟前';
        } elseif ($now - $time < 24 * 3600) {
            return floor(($now - $time) / 3600) . '小时前';
        } elseif ($now - $time < 3 * 24 * 3600) {
            return floor(($now - $time) / (24 * 3600)) . '天前';
        } else {
            return date('Y年m月d日', $time);
        }
    }
}

if (!function_exists('get_week_day')) {

    function get_week_day($num)
    {
        switch ($num) {
            case 0:
                $str = "星期天";
                break;
            case 1:
                $str = "星期一";
                break;
            case 2:
                $str = "星期二";
                break;
            case 3:
                $str = "星期三";
                break;
            case 4:
                $str = "星期四";
                break;
            case 5:
                $str = "星期五";
                break;
            case 6:
                $str = "星期六";
                break;
            default:
                $str = "";
        }
        return $str;
    }

}
