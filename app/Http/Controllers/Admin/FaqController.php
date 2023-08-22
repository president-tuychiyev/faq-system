<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Indentation;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::NotDeleted()->orderBy('turn')->with('creator')->get();
        $idn = Indentation::first();
        $message = request()->session()->get('message');
        return Inertia::render('Dashboard', compact('faqs', 'idn', 'message'));
    }

    public function store()
    {
        $faqs = collect(request()->all())->map(function ($item) {
            unset($item['isEmptyAnswer']);
            unset($item['isEmptyQuest']);
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
        Faq::where('id', request()->id)->update(request()->except('creator', 'created_at'));

        return back()->with('message', "Данные обновлены");
    }

    public function destroy()
    {
        Faq::where('id', request()->id)->update(['isDeleted' => true]);

        return back()->with('message', "Данные удалены");
    }

    public function idnUpdate()
    {
        Indentation::where('id', 1)->update([
            'top' => request()->top,
            'bottom' => request()->bottom
        ]);

        return back()->with('message', "Данные обновлены");
    }
}
