<?php

namespace App\Http\Repositories;

use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemRepository extends Repository
{
    const FIELD_BARCODE = 'barcode';
    const FIELD_NAME = 'name';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_PRICE = 'prices';
    const FIELD_PRICE_AMOUNT = 'prices.*.amount';
    const FIELD_PRICE_CURRENCY = 'prices.*.currency';

    /**
     * @param  \App\Models\Item  $item
     * @param  array  $data
     * @return \App\Models\Item
     * @throws \Exception
     */
    public function update(Item $item, array $data): Item
    {
        DB::beginTransaction();
        try {
            // Update model
            foreach ($data as $key => $value) {
                switch ($key) {
                    case self::FIELD_BARCODE:
                        $item->barcode = $value;
                        break;
                    case self::FIELD_NAME:
                        $item->name = $value;
                        break;
                    case self::FIELD_DESCRIPTION:
                        $item->description = $value;
                        break;
                }
            }
            $item->save();

            // Update relationships
            foreach ($data[self::FIELD_PRICE] as $subKey => $subValue) {
                /** @var \App\Models\Price $itemPrice */
                $itemPrice = $item->Prices()
                    ->firstOrNew([
                        'currency' => $subValue['currency'],
                    ]);

                $itemPrice->amount = $subValue['amount'];
                $itemPrice->currency = $subValue['currency'];
                $itemPrice->save();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Log to error monitoring service
            throw $e;
        }
        DB::commit();

        return $item;
    }


    /**
     * @return array
     */
    protected function getRuleTypes(): array
    {
        return [
            self::FIELD_BARCODE => [],
            self::FIELD_NAME => ['string', 'nullable'],
            self::FIELD_DESCRIPTION => ['string', 'nullable'],
            self::FIELD_PRICE => [],
            self::FIELD_PRICE_AMOUNT => ['gt:0'],
            self::FIELD_PRICE_CURRENCY => ['min:3', 'max:3'],
        ];
    }

    /**
     * @return array
     */
    protected function getRuleRequirementsCreate(): array
    {
        return [
            self::FIELD_BARCODE,
            self::FIELD_PRICE,
            self::FIELD_PRICE_AMOUNT,
            self::FIELD_PRICE_CURRENCY,
        ];
    }
}
