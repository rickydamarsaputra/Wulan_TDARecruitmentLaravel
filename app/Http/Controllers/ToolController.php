<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Member;
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

    public function findLowongan($idLowongan)
    {
        $lowongan = Lowongan::findOrfail($idLowongan);
        return response()->json([
            'lowongan' => $lowongan
        ]);
    }
}
