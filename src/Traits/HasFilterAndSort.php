<?php

namespace Iamxcd\LaravelCRUD\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait HasFilterAndSort
{
    /**
     * 允许哪些字段
     */
    protected $filterableFields = ['id'];

    /**
     * 过滤器关键字
     */
    private $filtersKeyword = ['cs', 'eq'];

    /**
     * 排序关键字
     */
    protected $sortKeyword = '_sort';

    /**
     * 允许排序的字段
     */
    protected $sortableFields = ['id'];


    protected function filterAndSort(Model $model, Request $request)
    {
        if (count($this->filterableFields) == 0) {
            return $model;
        }

        $params = $request->only($this->filterableFields);
        // 过滤空值
        $params = array_filter($params, function ($val) {
            return !is_null($val);
        });

        if (count($params) == 0) {
            return $model;
        }

        /**
         * 处理搜索
         */
        foreach ($params as $key => $val) {
            $kw = explode(',', $val);
            if (!in_array($kw[0], $this->filtersKeyword)) {
                $model = $this->eq($key, $val, $model);
                continue;
            }

            $model =  $this->{$kw[0]}($key, $kw, $model);
        }

        /**
         * 处理排序
         */

        if ($request->has($this->sortKeyword)) {
            $sort =  explode(',', $request->{$this->sortKeyword});
            if (in_array($sort[0], $this->sortableFields)) {
                $model = $model->orderBy($sort[0], count($sort) == 2 ? 'desc' : 'asc');
            }
        }

        return $model;
    }

    /**
     * contain string (包含字符串)
     * 
     */
    private function cs($key, $kw, $model)
    {
        /**
         * 将后面多解析的参数合并
         */
        array_shift($kw);
        $val = implode(',', $kw);
        return $model->where($key, 'like', '%' . $val . '%');
    }

    /**
     * equal (字符串或者数字完全匹配  可以省略)
     */
    private function eq($key, $val, $model)
    {
        /**
         * 特殊情况处理
         */
        if ($val === 'true') $val = true;
        if ($val === 'false') $val = false;

        return $model->where($key, $val);
    }
}
