<?php

namespace Iamxcd\LaravelCRUD\Traits;

use Illuminate\Http\Request;

/**
 * 主要给前端下拉选项框用
 */
trait HasOption
{
    protected $optionValue = 'id';

    protected $optionLable = 'name';


    public function option(Request $request)
    {
        $model = $this->model::query();
        if ($request->has('key')) {
            $model->where($this->optionLable, 'like', '%' . $request->key . '%');
        }
        $data = $model->get([$this->optionValue . ' as value', $this->optionLable . ' as lable'])->toArray();
        return $this->response($data, '获取成功');
    }
}
