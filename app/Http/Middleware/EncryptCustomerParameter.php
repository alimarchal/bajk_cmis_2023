<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;

class EncryptCustomerParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Encrypt the customer parameter for outgoing responses
        if ($request->route('customer')) {
            $request->route()->setParameter('customer', Crypt::encrypt($request->route('customer')));
        }
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Decrypt the customer parameter for incoming requests
        if ($response instanceof \Illuminate\Http\Request && $response->route('customer')) {
            $response->route()->setParameter('customer', Crypt::decrypt($response->route('customer')));
        }
    }
}
