<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Repositories\CurrencyRepository;
use Cookie;

class CheckDefaultCurrencyCookie {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The Currency Repository
     *
     * @var Guard
     */
    protected $currency;

    /**
     * Create a new filter instance.
     *
     */
    public function __construct(CurrencyRepository $currency) {
        $this->auth = Auth();
        $this->currency = $currency;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $default_currency = $this->currency->default_one();
        if (!$default_currency) {
            return $next($request);
        }
        if ($request->hasCookie('DefaultCurrency')) {
            if (Cookie::get('DefaultCurrency') == $default_currency->code) {
                return $next($request);
            }
        }

        $currency = $default_currency ? $default_currency->code : '';
        $response = $next($request);
        return $response->withCookie(Cookie::make('DefaultCurrency', $currency, 7 * 60 * 24));
    }

}
