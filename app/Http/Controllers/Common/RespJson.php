<?php
namespace App\Http\Controllers\Common;
/**
 * Created by PhpStorm.
 * User: wuhong
 * Date: 16/10/29
 * Time: 下午2:45
 */
class RespJson
{


    public $code = 0;
    public $msg = "成功";
    public $data;

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }


    /**
     * @param mixed $data
     */
    public function succeed($msg = null, $data = null)
    {
        $this->code = 0;
        $this->msg = isset($msg) ? $msg : '成功';
        if (isset($data)) {
            $this->data = $data;
        }
        return response()->json($this);
    }

    /**
     * @param mixed $data
     */
    public function validator($msg = null)
    {
        $this->code = 1;
        $this->msg = isset($msg) ? $msg : '效验失败';
        return response()->json($this);
    }

    /**
     * @param mixed $data
     */
    public function errors($msg = null)
    {
        $this->code = 2;
        $this->msg = isset($msg) ? $msg : '数据错误';
        return response()->json($this);
    }

    /**
     * @param mixed $data
     */
    public function exception($msg = null)
    {
        $this->code = -1;
        $this->msg = isset($msg) ? $msg : '系统异常';
        return response()->json($this);
    }
}