<?php

namespace Iamxcd\LaravelCRUD\Traits;

use Exception;
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
        'between-date',
        'boolean', // laravel 布尔值在数据库中是存的1和0 ,这里转化一下
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
            return $model->where($key, $operation, '%' . $kw[1] . '%');
        }

        if ($operation == 'between-date') {
            if (!strtotime($kw[1])  || !strtotime($kw[1])) {
                throw new Exception("格式错误");
            }
            return $model->whereBetween($key, [$kw[1], $kw[2]]);
        }

        if ($operation == 'boolean') {
            return  $model->where($key, $kw[1] == 'true' ? 1 : 0);
        }

        return  $model->where($key, $operation, $kw);
    }
}
