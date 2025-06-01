<?php

namespace App\Http\Response;

use Illuminate\Support\Facades\Auth; 
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    // public function toResponse($request)
    // {
    //     return $request->wantsJson()
    //                 ? response()->json(['two_factor' => false])
    //                 : redirect()->intended('admin/dashboard');
    // }
    public function toResponse($request)
    {
        $user = Auth::user(); // For default web guard

        if ($user && $user->user_type === 'admin') {
            return redirect()->intended('admin/dashboard');
        }

        return redirect()->intended('/dashboard');
    }

}
