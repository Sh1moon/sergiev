<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleFile;
use App\Models\ArticleSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $sectionId = $request->get('section_id');
        $query = Article::with(['section', 'user'])->orderByDesc('updated_at');

        if ($sectionId) {
            $query->where('article_section_id', $sectionId);
        }

        $articles = $query->paginate(15);
        $sections = ArticleSection::orderBy('sort_order')->get();

        return view('staff.articles.index', compact('articles', 'sections'));
    }

    public function create()
    {
        $sections = ArticleSection::orderBy('sort_order')->get();
        return view('staff.articles.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'article_section_id' => 'required|exists:article_sections,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
            'published_at' => 'nullable|date',
            'files.*' => array_merge(['nullable'], $this->fileUploadRules()),
        ]);

        $data = $request->only('article_section_id', 'title', 'excerpt', 'body', 'published_at');
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article = Article::create($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (!$file->isValid()) {
                    continue;
                }
                $path = $file->store('article-files', 'public');
                $article->files()->create([
                    'original_name' => $this->safeFileOriginalName($file),
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('staff.articles.index')
            ->with('success', 'Статья создана');
    }

    public function edit(Article $article)
    {
        $article->load('files');
        $sections = ArticleSection::orderBy('sort_order')->get();
        return view('staff.articles.edit', compact('article', 'sections'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'article_section_id' => 'required|exists:article_sections,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'published_at' => 'nullable|date',
            'files.*' => array_merge(['nullable'], $this->fileUploadRules()),
        ]);

        $data = $request->only('article_section_id', 'title', 'excerpt', 'body', 'published_at');

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (!$file->isValid()) {
                    continue;
                }
                $path = $file->store('article-files', 'public');
                $article->files()->create([
                    'original_name' => $this->safeFileOriginalName($file),
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('staff.articles.index')
            ->with('success', 'Статья обновлена');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        foreach ($article->files as $file) {
            Storage::disk('public')->delete($file->path);
        }
        $article->delete();
        return redirect()->route('staff.articles.index')
            ->with('success', 'Статья удалена');
    }

    public function destroyFile(Article $article, ArticleFile $file)
    {
        if ($file->article_id !== $article->id) {
            abort(404);
        }
        Storage::disk('public')->delete($file->path);
        $file->delete();
        return back()->with('success', 'Файл удалён');
    }

    /** Максимальный размер файла статьи в КБ (100 МБ). */
    private const FILE_MAX_KB = 102400;

    /**
     * Правила валидации загружаемых файлов статей.
     * Без правила "max" — иначе Laravel до нашей проверки выводит "The files.0 failed to upload".
     * Размер и ошибка загрузки проверяются в замыкании.
     */
    private function fileUploadRules(): array
    {
        return [
            function (string $attribute, $value, \Closure $fail): void {
                if (!$value instanceof \Illuminate\Http\UploadedFile) {
                    return;
                }
                if (!$value->isValid()) {
                    $code = $value->getError();
                    $messages = [
                        UPLOAD_ERR_INI_SIZE => 'Файл слишком большой: превышен лимит PHP (upload_max_filesize). Увеличьте его в php.ini (рекомендуется не менее 100 МБ).',
                        UPLOAD_ERR_FORM_SIZE => 'Файл превышает максимальный размер формы (post_max_size).',
                        UPLOAD_ERR_PARTIAL => 'Файл загружен частично. Попробуйте отправить форму снова.',
                        UPLOAD_ERR_NO_FILE => 'Файл не был выбран или не загружен.',
                        UPLOAD_ERR_NO_TMP_DIR => 'На сервере отсутствует временная папка для загрузки.',
                        UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                        UPLOAD_ERR_EXTENSION => 'Загрузка остановлена расширением PHP.',
                    ];
                    $fail($messages[$code] ?? 'Ошибка загрузки (код ' . $code . '). Проверьте настройки PHP: upload_max_filesize и post_max_size.');
                    return;
                }
                if ($value->getSize() > self::FILE_MAX_KB * 1024) {
                    $fail('Размер файла не должен превышать 100 МБ.');
                }
            },
        ];
    }

    /**
     * Безопасное имя файла для БД: кириллица, длинные имена, пустое имя.
     * Колонка original_name — string(255).
     */
    private function safeFileOriginalName(\Illuminate\Http\UploadedFile $file): string
    {
        $name = $file->getClientOriginalName();
        $name = trim((string) $name);
        if ($name === '' || !mb_check_encoding($name, 'UTF-8')) {
            return $this->fallbackFileName($file);
        }
        $name = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $name);
        if ($name === '') {
            return $this->fallbackFileName($file);
        }
        if (mb_strlen($name) > 250) {
            $ext = $file->getClientOriginalExtension() ?: pathinfo($name, PATHINFO_EXTENSION) ?: 'bin';
            $maxBase = 249 - strlen($ext);
            $name = mb_substr($name, 0, $maxBase) . '.' . $ext;
        }
        return $name;
    }

    private function fallbackFileName(\Illuminate\Http\UploadedFile $file): string
    {
        $ext = $file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin';
        return 'file-' . Str::random(8) . '.' . $ext;
    }
}
