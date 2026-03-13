<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function index(Request $request)
    {
        $query = Appeal::with(['user', 'responder'])->orderByDesc('created_at');

        $filter = $request->get('filter', 'new');
        if ($filter === 'archived') {
            $query->archived();
        } else {
            $query->new();
        }

        $search = $request->get('q');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('fio', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('postal_address', 'like', '%' . $search . '%');
            });
        }

        $appeals = $query->paginate(20)->withQueryString();

        return view('staff.appeals.index', [
            'appeals' => $appeals,
            'filter' => $filter,
            'search' => $search,
        ]);
    }

    public function show(Appeal $appeal)
    {
        $appeal->load(['user', 'responder']);
        return view('staff.appeals.show', compact('appeal'));
    }

    public function respond(Request $request, Appeal $appeal)
    {
        $request->validate([
            'response' => 'required|string|max:10000',
        ], [
            'response.required' => 'Введите текст ответа.',
        ]);

        $appeal->update([
            'response' => $request->response,
            'responded_at' => now(),
            'responded_by' => auth()->id(),
        ]);

        return redirect()->route('staff.appeals.index', ['filter' => 'new'])
            ->with('success', 'Ответ на обращение сохранён. Обращение перемещено в архив.');
    }
}
