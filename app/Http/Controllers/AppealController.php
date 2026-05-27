<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\ProblemCategory;
use App\Models\ProblemDetail;
use App\Models\ProblemSubcategory;
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
            ->with(['problemCategory', 'problemSubcategory', 'problemDetail'])
            ->orderByDesc('created_at')
            ->get();

        $problemCategories = ProblemCategory::query()
            ->where('is_active', true)
            ->with([
                'subcategories' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
                'subcategories.details' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('appeals.index', [
            'myAppeals' => $myAppeals,
            'problemCategories' => $problemCategories,
        ]);
    }

    public function show(Appeal $appeal)
    {
        if ($appeal->user_id !== auth()->id()) {
            abort(403);
        }
        $appeal->load('responsePhotos');
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
        $problemCategories = ProblemCategory::query()
            ->where('is_active', true)
            ->with([
                'subcategories' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
                'subcategories.details' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('appeals.edit', [
            'appeal' => $appeal,
            'problemCategories' => $problemCategories,
        ]);
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
            'problem_category_id' => 'nullable|exists:problem_categories,id',
            'problem_subcategory_id' => 'nullable|exists:problem_subcategories,id',
            'problem_detail_id' => 'nullable|exists:problem_details,id',
            'body' => 'required|string|max:10000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
        ], [
            'fio.required' => 'Укажите ФИО.',
            'email.required' => 'Укажите адрес электронной почты.',
            'body.required' => 'Введите текст обращения.',
        ]);
        $data = $request->only('fio', 'postal_address', 'email', 'phone', 'body', 'problem_category_id', 'problem_subcategory_id', 'problem_detail_id');
        $this->normalizeProblemHierarchy($data);
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

    public function responsePhoto(Appeal $appeal, int $photoId)
    {
        if (!$this->canAccessAppeal($appeal)) {
            abort(404);
        }

        $photo = $appeal->responsePhotos()->whereKey($photoId)->first();
        if (!$photo) {
            abort(404);
        }

        $path = Storage::disk('public')->path($photo->path);
        if (!is_file($path)) {
            abort(404);
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';
        $name = basename($photo->path);

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
            'problem_category_id' => 'nullable|exists:problem_categories,id',
            'problem_subcategory_id' => 'nullable|exists:problem_subcategories,id',
            'problem_detail_id' => 'nullable|exists:problem_details,id',
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

        $data = $request->only('fio', 'postal_address', 'email', 'phone', 'body', 'problem_category_id', 'problem_subcategory_id', 'problem_detail_id');
        $this->normalizeProblemHierarchy($data);
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

    private function normalizeProblemHierarchy(array &$data): void
    {
        $data['problem_category_id'] = $data['problem_category_id'] ?: null;
        $data['problem_subcategory_id'] = $data['problem_subcategory_id'] ?: null;
        $data['problem_detail_id'] = $data['problem_detail_id'] ?: null;

        if (!$data['problem_subcategory_id']) {
            $data['problem_detail_id'] = null;
            return;
        }

        $subcategory = ProblemSubcategory::query()->find($data['problem_subcategory_id']);
        if (!$subcategory) {
            $data['problem_subcategory_id'] = null;
            $data['problem_detail_id'] = null;
            return;
        }

        $data['problem_category_id'] = $subcategory->problem_category_id;

        if (!$data['problem_detail_id']) {
            return;
        }

        $detail = ProblemDetail::query()->find($data['problem_detail_id']);
        if (!$detail || $detail->problem_subcategory_id !== $subcategory->id) {
            $data['problem_detail_id'] = null;
        }
    }
}
