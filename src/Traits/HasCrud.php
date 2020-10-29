<?php

namespace Iamxcd\LaravelCRUD\Traits;

use Illuminate\Http\Request;

trait HasCrud
{
    use HasResponse;
    protected $model;
    protected $request;

    public function index()
    {
        $request = app($this->request);
        $data = $this->model->paginate((int) $request->page_size ?? 15)->toArray();
        return $this->responsePaginate($data['data'], $data['total'], $data['current_page'], $data['per_page']);
    }

    public function store()
    {
        $request = app($this->request);
        $data = $request->validated();
        $this->model->create($data);
        return $this->responseMessage('创建成功');
    }

    public function show($id)
    {
        $data =  $this->model::find($id);
        if (is_null($data)) {
            return $this->responseError('记录不存在', 404);
        }

        return $this->response($data, '获取成功');
    }

    public function update($id)
    {
        $request = app($this->request);
        $data = $request->validated();
        $model = $this->model::find($id);
        if (is_null($model)) {
            return $this->responseError('记录不存在', 404);
        }

        $model->update($data);

        return $this->responseMessage('更新成功');
    }

    public function destroy($id)
    {

        $model = $this->model::find($id);
        if (is_null($model)) {
            return $this->responseError('记录不存在', 404);
        }

        $model::destroy($id);
        return $this->responseMessage('删除成功');
    }
}
