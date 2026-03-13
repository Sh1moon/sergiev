<?php

namespace App\Http\Controllers;

use App\Models\AnticorruptionReport;
use Illuminate\Http\Request;

class AnticorruptionController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Для отправки сообщения необходимо войти в систему.');
        }

        $myReports = AnticorruptionReport::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('anticorruption.index', [
            'myReports' => $myReports,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'body' => 'required|string|max:10000',
        ], [
            'email.required' => 'Укажите адрес электронной почты.',
            'email.email' => 'Некорректный адрес электронной почты.',
            'body.required' => 'Введите текст сообщения.',
        ]);

        AnticorruptionReport::create([
            'user_id' => auth()->id(),
            'email' => $request->email,
            'body' => $request->body,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('appeals.anticorruption')
            ->with('success', 'Сообщение принято. Ответ будет размещен на этой странице в ближайшее время.');
    }
}
