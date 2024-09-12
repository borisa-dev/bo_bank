<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CrudTrait
{
    abstract public function getModel(): Builder;


    public function create(array $data)
    {
        return $this->getModel()->create($data);
    }

    public function findById($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    public function update($id, array $data): mixed
    {
        $record = $this->findById($id);
        $record->fill($data)->save();
        return $record;
    }

    public function deleteById($id)
    {
        return $this->findById($id)->delete();
    }
}
