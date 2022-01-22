<?php

namespace App\Http\Middleware;

use Closure;

class GoogleRecaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $redirect = false;

        $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');

        $params = [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
            //'response' => env('GOOGLE_RECAPTCHA_SITE_KEY')
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true
        ];

        curl_setopt_array($curl, $options);

        $recaptcha = json_decode(curl_exec($curl));

        if ($recaptcha->success == true) {
            $redirect = true;
        }

        curl_close($curl);
        if ($redirect) {
            return $next($request);
        }
        else {
            abort(404);
        }
    }
}
