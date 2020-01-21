<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 *
 * @package App\Repositories
 */
class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * {@inheritDoc}
     */
    public function first(string $conditions, string $value)
    {
        return $this->model->where($conditions, $value)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function find(array $conditions = [])
    {
        return $this->model->where($conditions)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function findByConditionLike(string $condition, string $value)
    {
        return $this->model->where($condition, 'like', $value . '%')->get();
    }

    /**
     * {@inheritDoc}
     */
    public function findOne(array $conditions)
    {
        return $this->model->where($conditions)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function findById(int $id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function findByCondition(string $condition, int $value)
    {
        return $this->model->where($condition, $value)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function firstOrFail(string $condition, string $value)
    {
        return $this->model->where($condition, $value)->firstOrFail();
    }

    /**
     * {@inheritDoc}
     */
    public function exists(string $condition, string $value)
    {
        return $this->model->where($condition, $value)->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }


    /**
     * {@inheritDoc}
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->model->firstOrCreate($attributes, $values);
    }

    /**
     * {@inheritDoc}
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Model $model, array $attributes = [])
    {
        return $model->update($attributes);
    }

    /**
     * {@inheritDoc}
     */
    public function save(Model $model)
    {
        return $model->save();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }
}
