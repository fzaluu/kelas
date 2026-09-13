<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Core\SchoolClass;
use App\Models\Content\ClassProfile;

class HomeController extends Controller
{
    public function index()
    {
        $class = SchoolClass::where('status', 'ACTIVE')->first();
        $profile = $class ? ClassProfile::where('class_id', $class->id)->first() : null;

        return view('pages.public.home', compact('class', 'profile'));
    }
}