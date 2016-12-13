<?php

namespace App\Http\Service;

use App\Http\Facades\Base;
use Exception;
use Illuminate\Support\Facades\Cache;
use stdClass;

/**
 * 微信服务
 * @package App\Http\Service
 */
class WeixinService
{
    private $appid = null;
    private $secret = null;

    public function __construct()
    {
        $this->appid = Base::maps('weixin_appid');
        $this->secret = Base::maps('weixin_appsecret');

    }


    public function token($appid = null, $secret = null)
    {

        $data = Cache::get('weixin_access_token', function () use ($appid, $secret) {

            if ($appid == null) {
                $appid = $this->appid;
            }
            if ($secret == null) {
                $secret = $this->secret;
            }

            $url = 'https://api.weixin.qq.com/cgi-bin/token';
            $data = array('grant_type' => 'client_credential', 'appid' => $appid, 'secret' => $secret);
            $response = curl($url, 'GET', $data);
            if ($response) {
                $obj = json_decode($response);
                if (isset($obj->errcode)) {
                    return $obj->errmsg;
                }
                Cache::put(['weixin_access_token' => $obj->access_token], $obj->expires_in / 60);
                return $obj->access_token;
            }
            return '';
        });
        return $data;
    }

    /**
     * 获取用户列表
     * @param null $openid
     * @return mixed|string
     */
    public function userList($openid = null)
    {
        try {
            $url = 'https://api.weixin.qq.com/cgi-bin/user/get';
            $data = array('access_token' => $this->token(), 'next_openid' => $openid);
            $response = curl($url, 'GET', $data);
            if ($response) {
                $obj = json_decode($response);
                if (isset($obj->errcode)) {
                    return $obj->errmsg;
                }
                return $obj;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * 获取用户详情
     * @param $openid
     * @return mixed
     */
    public function userInfo($openid)
    {
        try {
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info';
            $data = array('access_token' => $this->token(), 'openid' => $openid, 'lang' => 'zh_CN ');
            $response = curl($url, 'GET', $data);
            if ($response) {
                $obj = json_decode($response);
                if (isset($obj->errcode)) {
                    return $obj->errmsg;
                }
                $obj->subscribe_time = date('Y-m-d H:i:s', $obj->subscribe_time);
                return $obj;
            }
        } catch (Exception $ex) {
        }
    }

    /**
     * 修改用户备注
     * @param $openid
     * @param $remark
     */
    public function userRemark($openid, $remark)
    {
        try {
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=' . $this->token();
            $obj = new stdClass();
            $obj->openid = $openid;
            $obj->remark = $remark;
            $response = curl($url, 'POST', json_encode($obj));
            if ($response) {
                $obj = json_decode($response);
                if ($obj->errcode == 0) {
                    return true;
                }
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * 获取用户标签
     */
    public function userTags()
    {
        try {
            $url = 'https://api.weixin.qq.com/cgi-bin/tags/get';
            $data = array('access_token' => $this->token());
            $response = curl($url, 'GET', $data);
            if ($response) {
                $obj = json_decode($response);
                if (isset($obj->tags)) {
                    return $obj;
                }
            }
        } catch (Exception $ex) {
        }
    }
}