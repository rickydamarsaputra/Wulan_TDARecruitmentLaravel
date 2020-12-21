<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ToolController extends Controller
{
    public function generateSlug($slug)
    {
        $generateSlug = Str::slug($slug, '-');
        return response()->json([
            'slug' => $generateSlug
        ]);
    }

    public function generatePassword()
    {
        $randomPassword = Str::random(rand(15, 30));
        return response()->json([
            'password' => $randomPassword,
        ]);
    }
}
