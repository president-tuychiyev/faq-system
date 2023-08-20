<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $faqs = Faq::NotDeleted()->orderBy('turn')->get();

        return Inertia::render('Home', compact('faqs'));
    }
}
