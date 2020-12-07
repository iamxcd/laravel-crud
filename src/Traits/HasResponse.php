<?php

namespace Iamxcd\LaravelCRUD\Traits;

use Illuminate\Support\Facades\Response;

trait HasResponse
{

    public function response($data, $message = '', $code = 0, $headers = [])
    {

        $re_data = [
            'code' => $code,
            'message' => $message,
        ];
        if ($data) {
            $re_data['data'] = $data;
        }
        return Response::json($re_data, 200, $headers);
    }

    public function responsePaginate($data, $total, $page, $page_size)
    {

        $re_data = [
            'code' => 0,
            'message' => '获取成功',
            'data' => $data,
            'paginate' => [
                'page' => $page,
                'page_size' => $page_size,
                'total' => $total,
            ]
        ];
        return Response::json($re_data, 200);
    }

    public function responseMessage($message = '', $code = 0)
    {
        return $this->response(null, $message, $code);
    }

    public function responseError($message = '', $code = 1)
    {
        return $this->response(null, $message, $code);
    }
}
