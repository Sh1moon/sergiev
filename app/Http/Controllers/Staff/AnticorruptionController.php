<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AnticorruptionReport;
use Illuminate\Http\Request;

class AnticorruptionController extends Controller
{
    public function index(Request $request)
    {
        $query = AnticorruptionReport::with(['user', 'responder'])->orderByDesc('created_at');

        $filter = $request->get('filter', 'new');
        if ($filter === 'archived') {
            $query->archived();
        } else {
            $query->new();
        }

        $search = $request->get('q');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            });
        }

        $reports = $query->paginate(20)->withQueryString();

        return view('staff.anticorruption.index', [
            'reports' => $reports,
            'filter' => $filter,
            'search' => $search,
        ]);
    }

    public function show(AnticorruptionReport $report)
    {
        $report->load(['user', 'responder']);
        return view('staff.anticorruption.show', ['report' => $report]);
    }

    public function respond(Request $request, AnticorruptionReport $report)
    {
        $request->validate([
            'response' => 'required|string|max:10000',
        ], [
            'response.required' => 'Введите текст ответа.',
        ]);

        $report->update([
            'response' => $request->response,
            'responded_at' => now(),
            'responded_by' => auth()->id(),
        ]);

        return redirect()->route('staff.anticorruption.index', ['filter' => 'new'])
            ->with('success', 'Ответ сохранён. Сообщение перемещено в архив.');
    }
}
