<?php

namespace Database\Seeders;

use App\Http\Repositories\ItemRepository;
use App\Interfaces\IRepository;
use App\Models\Currency;
use App\Models\Item;
use App\Models\Price;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * @var \App\Http\Repositories\ItemRepository
     */
    private IRepository $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Remove existing data
        Item::query()->truncate();
        Price::query()->truncate();
        Currency::query()->truncate();

        // Add data using repository
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 25; $i++) {
            $this->repository->update(new Item(), [
                $this->repository::FIELD_BARCODE => $faker->ean13(),
                $this->repository::FIELD_NAME => $faker->name,
                $this->repository::FIELD_DESCRIPTION => $faker->sentence,
                $this->repository::FIELD_PRICE => [
                    [
                        'amount' => $faker->numberBetween(100, 2000),
                        'currency' => config('currency.default'),
                    ]
                ]
            ]);
        }

        // Add data using command
        Artisan::call('currency:load');
    }
}
