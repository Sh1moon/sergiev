<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppealController extends Controller
{
    private function canAccessAppeal(Appeal $appeal): bool
    {
        if ($appeal->user_id === auth()->id()) {
            return true;
        }
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->isEmployee());
    }

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Для отправки обращения необходимо войти в систему.');
        }

        $myAppeals = Appeal::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('appeals.index', [
            'myAppeals' => $myAppeals,
        ]);
    }

    public function show(Appeal $appeal)
    {
        if ($appeal->user_id !== auth()->id()) {
            abort(403);
        }
        return view('appeals.show', ['appeal' => $appeal]);
    }

    public function edit(Appeal $appeal)
    {
        if ($appeal->user_id !== auth()->id()) {
            abort(403);
        }
        if ($appeal->responded_at !== null) {
            return redirect()->route('appeals.show', $appeal)->with('error', 'Редактирование обращений с полученным ответом недоступно.');
        }
        return view('appeals.edit', ['appeal' => $appeal]);
    }

    public function update(Request $request, Appeal $appeal)
    {
        if ($appeal->user_id !== auth()->id()) {
            abort(403);
        }
        if ($appeal->responded_at !== null) {
            return redirect()->route('appeals.show', $appeal)->with('error', 'Редактирование обращений с полученным ответом недоступно.');
        }
        $request->validate([
            'fio' => 'required|string|max:255',
            'postal_address' => 'nullable|string|max:500',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'body' => 'required|string|max:10000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
        ], [
            'fio.required' => 'Укажите ФИО.',
            'email.required' => 'Укажите адрес электронной почты.',
            'body.required' => 'Введите текст обращения.',
        ]);
        $data = $request->only('fio', 'postal_address', 'email', 'phone', 'body');
        if ($request->hasFile('attachment')) {
            if ($appeal->attachment) {
                Storage::disk('public')->delete($appeal->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('appeals', 'public');
        }
        $appeal->update($data);
        return redirect()->route('appeals.show', $appeal)->with('success', 'Обращение обновлено.');
    }

    /**
     * Serve appeal attachment with Content-Disposition: inline so it opens in browser / new tab instead of download.
     */
    public function attachment(Appeal $appeal)
    {
        if (!$this->canAccessAppeal($appeal) || !$appeal->attachment) {
            abort(404);
        }
        $path = Storage::disk('public')->path($appeal->attachment);
        if (!is_file($path)) {
            abort(404);
        }
        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $name = basename($appeal->attachment);
        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . addslashes($name) . '"',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fio' => 'required|string|max:255',
            'postal_address' => 'nullable|string|max:500',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'body' => 'required|string|max:10000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
            'consent' => 'required|accepted',
        ], [
            'fio.required' => 'Укажите ФИО.',
            'email.required' => 'Укажите адрес электронной почты.',
            'email.email' => 'Некорректный адрес электронной почты.',
            'body.required' => 'Введите текст обращения.',
            'consent.required' => 'Необходимо согласие на обработку персональных данных.',
            'consent.accepted' => 'Необходимо согласие на обработку персональных данных.',
        ]);

        $data = $request->only('fio', 'postal_address', 'email', 'phone', 'body');
        $data['user_id'] = auth()->id();
        $data['consent'] = true;
        $data['ip_address'] = $request->ip();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('appeals', 'public');
        }

        Appeal::create($data);

        return redirect()->route('appeals')
            ->with('success', 'Обращение принято. Мы рассмотрим его в ближайшее время.');
    }
}
