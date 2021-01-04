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
    private $filtersKeyword = [
        'like', '=', '<', '<=', '>', '>=',
    ];

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
                $model = $this->general($key, '=', $val, $model);
                continue;
            }

            $model =  $this->general($key, $kw[0], $kw, $model);
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

    private function general($key, $operation, $kw, $model)
    {
        if ($operation == 'like') {
            return  $model->where($key, $operation, '%' . $kw[1] . '%');
        }

        return  $model->where($key, $operation, $kw);
    }
}
