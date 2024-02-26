<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveBadWords
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        
        if($request->input("name") && strpos($request->input("name"), "fuck") !== false) {

            $new_value = str_replace("fuck", "kkkk", $request->input("name"));

            $request->merge(['name' => $new_value]);
        }

        return $next($request);
    }

    protected $except = [
    ];
}
