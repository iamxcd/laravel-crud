<?php

namespace Iamxcd\LaravelCRUD\Traits;

use Validator;

trait HasBatchDelete
{
    /**
     * 批量删除
     *
     */
    public function batchDelete()
    {
        $params = Validator::make(
            $this->request->all(),
            [
                'ids' =>  'required|array',
                'ids.*' =>  'integer',
            ]
        )->validate();

        $this->model::query()->whereIn('id', $params['ids'])->delete();
        return $this->responseMessage('删除成功');
    }
}
