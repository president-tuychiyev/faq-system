<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Indentation;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $faqs = Faq::NotDeleted()->orderBy('turn')->get();
        $idn = Indentation::first();
        return Inertia::render('Home', compact('faqs', 'idn'));
    }
}
