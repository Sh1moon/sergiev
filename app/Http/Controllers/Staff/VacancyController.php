<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::with('user')->orderByDesc('updated_at')->paginate(15);
        return view('staff.vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        return view('staff.vacancies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        Vacancy::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('staff.vacancies.index')
            ->with('success', 'Вакансия создана');
    }

    public function edit(Vacancy $vacancy)
    {
        return view('staff.vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $vacancy->update($request->only('title', 'body', 'published_at'));

        return redirect()->route('staff.vacancies.index')
            ->with('success', 'Вакансия обновлена');
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return redirect()->route('staff.vacancies.index')
            ->with('success', 'Вакансия удалена');
    }
}
