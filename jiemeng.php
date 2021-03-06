<?php
// +----------------------------------------------------------------------
// | JuhePHP [ NO ZUO NO DIE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2015 http://juhe.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Juhedata <info@juhe.cn-->
// +----------------------------------------------------------------------

//----------------------------------
// 周公解梦调用示例代码 － 聚合数据
// 在线接口文档：http://www.juhe.cn/docs/64
//----------------------------------

class Oneiromancy
{

    protected  $appkey;


    public function __construct()
    {
        $this->appkey = '3b7e647316939205f798ea0611c97f22';

    }




//************1.类型************
public function category()
{
    $url = "http://v.juhe.cn/dream/category";
    $params = array(
        "key" => $this->appkey,//应用APPKEY(应用详细页查询)
        "fid" => "",//所属分类，默认全部，0:一级分类
    );
    $paramstring = http_build_query($params);
    $content = juhecurl($url, $paramstring);
    $result = json_decode($content, true);
    if ($result)
    {
        if ($result['error_code']=='0')
        {
            print_r($result);
        }

        else{
            echo $result['error_code'] . ":" . $result['reason'];
        }
    }else{
        echo "请求失败";
    }
}

//**************************************************


//************2.解梦查询************
public function query()
{
    $url = " http://v.juhe.cn/dream/query";
    $params = array(
        "key" => $this->appkey,//应用APPKEY(应用详细页查询)
        "q" => "",//梦境关键字，如：黄金 需要utf8 urlencode
        "cid" => "",//指定分类，默认全部
        "full" => "1",//是否显示详细信息，1:是 0:否，默认0
    );
    $paramstring = http_build_query($params);
    $content = juhecurl($url, $paramstring);
    $result = json_decode($content, true);
    if ($result) {
        if ($result['error_code'] == '0') {
            print_r($result);
        } else {
            echo $result['error_code'] . ":" . $result['reason'];
        }
    } else {
        echo "请求失败";
    }
}

//**************************************************





/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url, $params = false, $ispost = 0)
{
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);
    if ($response === FALSE) {
//echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
    curl_close($ch);
    return $response;
}
}
?>