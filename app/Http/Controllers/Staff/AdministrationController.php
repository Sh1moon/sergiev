<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdministrationHead;
use App\Models\AdministrationDeputy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdministrationController extends Controller
{
    public function index()
    {
        $head = AdministrationHead::first();
        $deputies = AdministrationDeputy::orderBy('sort_order')->orderBy('id')->get();
        return view('staff.administration.index', compact('head', 'deputies'));
    }

    public function editHead()
    {
        $head = AdministrationHead::firstOrCreate([], [
            'title' => '',
            'description' => '',
        ]);
        return view('staff.administration.edit-head', compact('head'));
    }

    public function updateHead(Request $request)
    {
        $head = AdministrationHead::firstOrCreate([], [
            'title' => '',
            'description' => '',
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only('title', 'description');

        if ($request->hasFile('photo')) {
            if ($head->photo) {
                Storage::disk('public')->delete($head->photo);
            }
            $data['photo'] = $request->file('photo')->store('administration', 'public');
        }

        if ($request->boolean('photo_remove') && $head->photo) {
            Storage::disk('public')->delete($head->photo);
            $data['photo'] = null;
        }

        $head->update($data);

        return redirect()->route('staff.administration.index')
            ->with('success', 'Раздел «Глава округа» обновлён');
    }

    public function editDeputy(AdministrationDeputy $deputy)
    {
        return view('staff.administration.edit-deputy', compact('deputy'));
    }

    public function updateDeputy(Request $request, AdministrationDeputy $deputy)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'contacts' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only('name', 'position', 'description', 'contacts', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['slug'] = Str::slug($request->name) ?: 'zam-' . $deputy->id;

        if ($request->hasFile('photo')) {
            if ($deputy->photo) {
                Storage::disk('public')->delete($deputy->photo);
            }
            $data['photo'] = $request->file('photo')->store('administration', 'public');
        }

        if ($request->boolean('photo_remove') && $deputy->photo) {
            Storage::disk('public')->delete($deputy->photo);
            $data['photo'] = null;
        }

        $deputy->update($data);

        return redirect()->route('staff.administration.index')
            ->with('success', 'Заместитель обновлён');
    }

    public function createDeputy()
    {
        return view('staff.administration.edit-deputy', ['deputy' => new AdministrationDeputy()]);
    }

    public function storeDeputy(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'contacts' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:5120',
        ]);

        $data = $request->only('name', 'position', 'description', 'contacts');
        $data['sort_order'] = (int) $request->get('sort_order', 0);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('administration', 'public');
        }

        AdministrationDeputy::create($data);

        return redirect()->route('staff.administration.index')
            ->with('success', 'Заместитель добавлен');
    }

    public function destroyDeputy(AdministrationDeputy $deputy)
    {
        if ($deputy->photo) {
            Storage::disk('public')->delete($deputy->photo);
        }
        $deputy->delete();
        return redirect()->route('staff.administration.index')
            ->with('success', 'Заместитель удалён');
    }
}
