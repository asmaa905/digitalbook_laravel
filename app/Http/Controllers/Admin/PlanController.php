<?php
namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends BaseController
{
    public function index()
    {
        $plans = Plan::all();
        return view('Admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('Admin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'features' => 'required|string', // change from array to string
            'plan_duration' => 'nullable|integer',

            'book_limit' => 'nullable|integer',
            'instant_download' => 'boolean',
            'free_trial_days' => 'integer|min:0',
            'is_featured' => 'boolean'
        ]);

        // Convert features text to array
        $validated['features'] = array_filter(
            explode("\n", str_replace("\r", "", $validated['features']))
        );
        Plan::create($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');
    }

    public function edit(Plan $plan)
    {
        return view('Admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'features' => 'required|string', // change from array to string
            'plan_duration' => 'nullable|integer',

            'book_limit' => 'nullable|integer',
            'instant_download' => 'boolean',
            'free_trial_days' => 'integer|min:0',
            'is_featured' => 'boolean'
        ]);

        // Convert features text to array
        $validated['features'] = array_filter(
            explode("\n", str_replace("\r", "", $validated['features']))
        );

        $plan->update($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully');
    }
}