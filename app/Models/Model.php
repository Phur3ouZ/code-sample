<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * For the purposes of this code sample - disabling guarded columns for easy property assignment
     *
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * @param  array  $data
     * @return static
     * @throws \Exception
     */
    public function updateWithTransaction(array $data): static
    {
        DB::beginTransaction();
        try {
            $this->fill($data);
            $this->save();
        } catch (\Exception $e) {
            DB::rollBack();
            // Log to error monitoring service
            throw $e;
        }
        DB::commit();

        return $this;
    }
}
