<?php

// app/Http/Controllers/PublishHouseController.php
namespace App\Http\Controllers;

use App\Models\PublishHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublishHouseController extends Controller
{
    public function index()
    {
        $publishHouses = PublishHouse::latest()->paginate(10);
        return view('admin.publish-houses.index', compact('publishHouses'));
    }

    public function create()
    {
        return view('admin.publish-houses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publish_houses',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('publish-houses', 'public');
        }

        PublishHouse::create($validated);
        
        return redirect()->route('admin.publish-houses.index')->with('success', 'Publish House created successfully');
    }

    public function edit(PublishHouse $publishHouse)
    {
        return view('admin.publish-houses.edit', compact('publishHouse'));
    }

    public function update(Request $request, PublishHouse $publishHouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publish_houses,name,'.$publishHouse->id,
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($publishHouse->logo) {
                Storage::disk('public')->delete($publishHouse->logo);
            }
            $validated['logo'] = $request->file('logo')->store('publish-houses', 'public');
        }

        $publishHouse->update($validated);
        
        return redirect()->route('admin.publish-houses.index')->with('success', 'Publish House updated successfully');
    }

    public function destroy(PublishHouse $publishHouse)
    {
        if ($publishHouse->books()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete publish house with associated books');
        }
        
        // Delete logo if exists
        if ($publishHouse->logo) {
            Storage::disk('public')->delete($publishHouse->logo);
        }
        
        $publishHouse->delete();
        return redirect()->route('admin.publish-houses.index')->with('success', 'Publish House deleted successfully');
    }
}