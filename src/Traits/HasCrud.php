<?php

namespace Iamxcd\LaravelCRUD\Traits;

trait HasCrud
{
    use HasResponse, HasFilterAndSort;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Illuminate\Foundation\Http\FormRequest
     */
    protected $request;

    /**
     * 筛选器
     */
    protected $filters;

    public function index()
    {
        $request = $this->request;
        $data = $this->filterAndSort($this->model, $request)->latest("id")->paginate((int) $request->page_size ?? 15)->toArray();

        return $this->responsePaginate($data['data'], $data['total'], $data['current_page'], $data['per_page']);
    }

    public function store()
    {
        $request = $this->request;
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
        $request = $this->request;
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
