<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $slides = CarouselSlide::orderBy('sort_order')->get();
        return view('staff.carousel.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $path = $request->file('image')->store('carousel', 'public');
        CarouselSlide::create([
            'image' => $path,
            'sort_order' => (int) $request->get('sort_order', 0),
        ]);
        return redirect()->route('staff.carousel.index')->with('success', 'Слайд добавлен');
    }

    public function edit(CarouselSlide $slide)
    {
        return view('staff.carousel.edit', compact('slide'));
    }

    public function update(Request $request, CarouselSlide $slide)
    {
        $request->validate([
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        if ($request->hasFile('image')) {
            if ($slide->image && Storage::disk('public')->exists($slide->image)) {
                Storage::disk('public')->delete($slide->image);
            }
            $slide->image = $request->file('image')->store('carousel', 'public');
        }
        $slide->sort_order = (int) $request->get('sort_order', 0);
        $slide->save();
        return redirect()->route('staff.carousel.index')->with('success', 'Слайд обновлён');
    }

    public function destroy(CarouselSlide $slide)
    {
        if ($slide->image && Storage::disk('public')->exists($slide->image)) {
            Storage::disk('public')->delete($slide->image);
        }
        $slide->delete();
        return redirect()->route('staff.carousel.index')->with('success', 'Слайд удалён');
    }
}
