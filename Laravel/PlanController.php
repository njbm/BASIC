<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    public function index()
    {
        $plans= Plan::all();
        return view('plan.index', compact('plans'));
    }

    public function create()
    {
        return view('plan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Define image validation rules
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/plan');
            $image->move($imagePath, $filename);
            $data['image']= $filename;

            // $imagePath = $request->file('image')->store('public/images/plan', 'public');
            // $data['image'] = str_replace('public/', '', $imagePath);
        }
        
    
        Plan::create($data);
    
        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }


    public function show(Plan $plan)
    {
        return view('plan.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('plan.edit', compact('plan'));
    }


    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Define image validation rules
        ]);
    

    // Check if a new image is being uploaded
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($plan->image) {
            $oldImagePath = public_path('images/plan/' . $plan->image);

            // Delete the old image if it exists
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        
        }

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = public_path('images/plan');
        $image->move($imagePath, $filename);
        $plan->image = $filename;
    }
        // Update the plan's attributes
        $plan->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            // Update other fields as needed
        ]);
    

    
        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }


    public function destroy(Plan $plan)
    {
        if ($plan->image) {
            
            $imagePath = public_path('images/plan/' . $plan->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $plan->delete();
    
        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }
}
