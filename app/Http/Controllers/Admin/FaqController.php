<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Carbon\Carbon;
use Inertia\Inertia;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::NotDeleted()->orderBy('turn')->with('creator')->get();
        $message = request()->session()->get('message');
        return Inertia::render('Dashboard', compact('faqs', 'message'));
    }

    public function store()
    {
        $faqs = collect(request()->all())->map(function ($item) {
            $item['created_at'] = Carbon::now()->toDateTimeString();
            $item['updated_at'] = Carbon::now()->toDateTimeString();
            $item['createdBy'] = auth()->user()->id;
            $item['updatedBy'] = auth()->user()->id;
            return $item;
        });

        Faq::insert($faqs->toArray());

        return back()->with('message', "Данные добавлены");
    }

    public function update()
    {
        Faq::where('id', request()->id)->update(request()->except('creator',));

        return back()->with('message', "Данные обновлены");
    }

    public function destroy()
    {
        Faq::where('id', request()->id)->update(['isDeleted' => true]);

        return back()->with('message', "Данные удалены");
    }
}
