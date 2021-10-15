<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Services\CurrencyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class CurrencyCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'currency:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load currencies into database';

    public function handle()
    {
        $this->info('Attempting to load currencies...');

        $service = new CurrencyService();
        try {
            $currencies = $service->getCurrencies();

            $this->info('Inserting currencies...');
            foreach ($currencies as $currency) {
                try {
                    $x = new Currency();
                    $x->updateWithTransaction([
                        'id' => $currency['id'],
                        'name' => $currency['currencyName'],
                        'symbol' => $currency['currencySymbol'] ?? null,
                    ]);

                    $this->line("Inserted currency: {$currency['id']}");
                } catch (\Exception $e) {
                    $this->error("Failed to insert {$currency['id']} because {$e->getMessage()}");
                }
            }

            $this->info('Currencies inserted!');
        } catch (GuzzleException $e) {
            $this->error("Couldn't connect to service due to error: ({$e->getMessage()})");
        }
    }
}
