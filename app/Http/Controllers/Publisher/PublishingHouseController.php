<?php

namespace App\Http\Controllers\Publisher;

use App\Models\PublishingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublishingHouseController extends BaseController
{
   
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

        return redirect()->route('publisher.books.create')
            ->with('success', 'Publishing house created successfully!');
    }

}