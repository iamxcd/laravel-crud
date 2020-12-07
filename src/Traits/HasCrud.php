<?php

namespace Iamxcd\LaravelCRUD\Traits;

trait HasCrud
{
    use HasResponse, HasFilterAndSort;
    protected $model;
    protected $request;

    /**
     * 筛选器
     */
    protected $filters;

    public function index()
    {
        $request = app($this->request);
        $data = $this->filterAndSort($this->model, $request)->paginate((int) $request->page_size ?? 15)->toArray();

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
        $data =  $this->model::findOrFail($id);
        return $this->response($data, '获取成功');
    }

    public function update($id)
    {
        $request = app($this->request);
        $data = $request->validated();
        $model = $this->model::findOrFail($id);
        $model->update($data);

        return $this->responseMessage('更新成功');
    }

    public function destroy($id)
    {
        $model = $this->model::findOrFail($id);
        $model::destroy($id);
        return $this->responseMessage('删除成功');
    }
}
