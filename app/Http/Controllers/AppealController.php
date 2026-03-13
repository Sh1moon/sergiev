<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppealController extends Controller
{
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
