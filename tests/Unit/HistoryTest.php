<?php

namespace Tests\Unit;

use App\Models\Item;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HistoryTest extends TestCase
{
    use InteractsWithDatabase;
    use RefreshDatabase;

    /**
     * @return \App\Models\Item
     */
    private function createItem(): Item
    {
        // Replace with a factory
        $item = new Item();
        $item->barcode = 1;
        $item->save();

        return $item;
    }

    /** @test */
    public function new_model_save_insert_none()
    {
        $this->createItem();

        $this->assertDatabaseCount('items_history', 0);
    }

    /** @test */
    public function existing_model_save_insert_one()
    {
        $item = $this->createItem();
        $item->barcode = 2;
        $item->save();

        $this->assertDatabaseCount('items_history', 1);
    }

    /** @test */
    public function existing_model_save_insert_n()
    {
        $item = $this->createItem();
        for ($i = 0; $i < 10; $i++) {
            $item->barcode = $i + 2;
            $item->save();
        }

        $this->assertDatabaseCount('items_history', 10);
    }

    /** @test */
    public function existing_model_save_without_history_insert_none()
    {
        $item = $this->createItem();
        for ($i = 0; $i < 10; $i++) {
            $item->barcode = $i + 2;
            $item->saveWithoutHistory();
        }

        $this->assertDatabaseCount('items_history', 0);
    }
}
