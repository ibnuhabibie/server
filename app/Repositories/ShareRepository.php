<?php

namespace App\Repositories;

use App\DynamoDbShare;
use App\Share;

class ShareRepository
{
    /** @var DynamoDbShare|Share  */
    protected $model;

    /**
     * ShareRepository constructor.
     *
     * @param Share|DynamoDbShare $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * @return Share|DynamoDbShare
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Find a model instance.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Return all instances.
     *
     * @return Share[]|\BaoPham\DynamoDb\DynamoDbCollection|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function all()
    {
        return $this->model->all();
    }
}
