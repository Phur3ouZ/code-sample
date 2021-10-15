<?php

namespace App\Http\Middleware;

use App\Services\CurrencyService;
use Closure;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Currency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'currency' => [],
        ]);

        // Attempt to get conversion rate
        try {
            $validated = $validator->validated();
            if (array_key_exists('currency', $validated)) {
                $currencyService = new CurrencyService();
                $currency = $validated['currency'];
                $rate = $currencyService->getConversionRate(config('currency.default'), $currency);

                config()->set('currency.request', $currency);
                config()->set('currency.rate', $rate);
            }
        } catch (ValidationException | GuzzleException $e) {
        }

        return $next($request);
    }
}
