<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Models\User,
    Illuminate\Support\Str,
    Illuminate\Support\Facades\Hash,
    Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', '!=', 'admin')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['bail', 'required', 'min:5', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['bail', 'required', 'email', 'unique:users'],
            'password' => ['bail', 'required', 'between:8,20', 'confirmed'],
            'role' => 'required'
        ]);
    
        // Clean and prepare data
        $validatedData['name'] = Str::title($validatedData['name']);
        $validatedData['email'] = Str::lower($validatedData['email']);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role'] = 'employee';
    
        // Create the user with the validated and prepared data
        User::create($validatedData);
    
        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(User $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        // Validate input
        $validatedData = $request->validate([
            'name' => ['bail', 'required', 'min:5', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['bail', 'required', 'email', Rule::unique('users')->ignore($employee->id)],
            'password' => ['bail', 'nullable', 'between:8,20', 'confirmed'],
        ]);
    
        // Clean and prepare data
        $validatedData['name'] = Str::title($validatedData['name']);
        $validatedData['email'] = Str::lower($validatedData['email']);
    
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
    
        // Update the user with the validated and prepared data
        $employee->update($validatedData);
    
        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }
    

    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
