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

    public function destroy(CarouselSlide $carousel)
    {
        Storage::disk('public')->delete($carousel->image);
        $carousel->delete();
        return redirect()->route('staff.carousel.index')->with('success', 'Слайд удалён');
    }
}
