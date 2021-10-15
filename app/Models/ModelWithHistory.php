<?php

namespace App\Models;

use App\Interfaces\IHistory;
use App\Models\History\History;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class ModelWithHistory extends Model implements IHistory
{
    /**
     * @var bool
     */
    protected $writeHistory = true;

    protected static function boot()
    {
        parent::boot();

        static::updated(function (ModelWithHistory $model) {
            if (!$model->writeHistory) {
                return;
            }

            $originalModel = $model->getOriginal();
            $originalModel['_id'] = $originalModel[$model->primaryKey];
            // Could indicate who made the change, based on authenticated user if this was implemented
            // $originalModel['updated_by'] = auth()->id();
            unset($originalModel[$model->primaryKey]);
            $model->History()->create($originalModel);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function History(): HasMany
    {
        $revision = new History();
        $revision->setTable($this->table . '_history');

        return (new HasMany(
            $revision->newQuery(),
            $this,
            $revision->getTable().'.'.'_id',
            $this->getKeyName()
        ))->orderBy('updated_at', 'desc');
    }

    /**
     * Save the model to the database without writing into the history table.
     *
     * @param  array  $options
     * @return bool
     */
    public function saveWithoutHistory(array $options = []): bool
    {
        $this->disableHistory();
        $save = parent::save($options);
        $this->enableHistory();

        return $save;
    }

    public function disableHistory(): void
    {
        $this->writeHistory = false;
    }

    public function enableHistory(): void
    {
        $this->writeHistory = true;
    }
}
