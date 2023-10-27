<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BasicUserResource;

class UserController extends Controller
{
    public function profile(Request $request): BasicUserResource
    {
        return BasicUserResource::make($request->user());
    }
}
