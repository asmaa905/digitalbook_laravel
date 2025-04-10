<?php

namespace App\Http\Controllers\Publisher;

use App\Models\PublishingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublishingHouseController extends BaseController
{
    public function index()
    {
        $publishingHouses = PublishingHouse::withCount('books')
            ->latest()
            ->paginate(10);
            
        return $this->view('publishing-houses.index', compact('publishingHouses'));
    }

    public function create()
    {
        return $this->view('publishing-houses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'website' => 'required|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('publishing-houses', 'public');
        }

        PublishingHouse::create($validated);

        return redirect()->route('publisher.publishing-houses.index')
            ->with('success', 'Publishing house created successfully!');
    }

    public function show(PublishingHouse $publishingHouse)
    {
        $publishingHouse->loadCount('books');
        
        return $this->view('publishing-houses.show', compact('publishingHouse'));
    }

    public function edit(PublishingHouse $publishingHouse)
    {
        return $this->view('publishing-houses.create', compact('publishingHouse'));
    }

    public function update(Request $request, PublishingHouse $publishingHouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'website' => 'required|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($publishingHouse->image) {
                Storage::disk('public')->delete($publishingHouse->image);
            }
            $validated['image'] = $request->file('image')->store('publishing-houses', 'public');
        }

        $publishingHouse->update($validated);

        return redirect()->route('publisher.publishing-houses.index')
            ->with('success', 'Publishing house updated successfully!');
    }

    public function destroy(PublishingHouse $publishingHouse)
    {
        // Delete image if exists
        if ($publishingHouse->image) {
            Storage::disk('public')->delete($publishingHouse->image);
        }
        
        $publishingHouse->delete();

        return redirect()->route('publisher.publishing-houses.index')
            ->with('success', 'Publishing house deleted successfully!');
    }
}