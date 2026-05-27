<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use App\Models\AppealResponsePhoto;
use App\Models\ProblemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppealController extends Controller
{
    public function index(Request $request)
    {
        $query = Appeal::with(['user', 'responder', 'problemCategory', 'problemSubcategory', 'problemDetail'])->orderByDesc('created_at');

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

        $categoryId = $request->integer('problem_category_id');
        if ($categoryId > 0) {
            $query->where('problem_category_id', $categoryId);
        }
        $subcategoryId = $request->integer('problem_subcategory_id');
        if ($subcategoryId > 0) {
            $query->where('problem_subcategory_id', $subcategoryId);
        }
        $detailId = $request->integer('problem_detail_id');
        if ($detailId > 0) {
            $query->where('problem_detail_id', $detailId);
        }

        $appeals = $query->paginate(20)->withQueryString();
        $problemCategories = ProblemCategory::query()
            ->where('is_active', true)
            ->with([
                'subcategories' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
                'subcategories.details' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('staff.appeals.index', [
            'appeals' => $appeals,
            'filter' => $filter,
            'search' => $search,
            'problemCategories' => $problemCategories,
            'selectedCategoryId' => $categoryId > 0 ? $categoryId : null,
            'selectedSubcategoryId' => $subcategoryId > 0 ? $subcategoryId : null,
            'selectedDetailId' => $detailId > 0 ? $detailId : null,
        ]);
    }

    public function show(Appeal $appeal)
    {
        $appeal->load(['user', 'responder', 'responsePhotos']);
        return view('staff.appeals.show', compact('appeal'));
    }

    public function respond(Request $request, Appeal $appeal)
    {
        $request->validate([
            'response' => 'required|string|max:10000',
            'response_photos' => 'nullable|array|max:10',
            'response_photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'response.required' => 'Введите текст ответа.',
        ]);

        DB::transaction(function () use ($request, $appeal) {
            $appeal->update([
                'response' => $request->response,
                'responded_at' => now(),
                'responded_by' => auth()->id(),
            ]);

            foreach ($request->file('response_photos', []) as $photo) {
                AppealResponsePhoto::create([
                    'appeal_id' => $appeal->id,
                    'path' => $photo->store('appeals/response-photos', 'public'),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        });

        return redirect()->route('staff.appeals.index', ['filter' => 'new'])
            ->with('success', 'Ответ на обращение сохранён. Обращение перемещено в архив.');
    }
}
