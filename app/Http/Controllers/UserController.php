<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            // 'student_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Administrator,Office,Student',
        ]);

        // Create a new user
        $user = User::create([
            // 'student_id' => $request->student_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'profile_picture' => 'images/PSU logo.png',
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('message', $request->name.' account successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'in:Administrator,Office,Student',
        ]);

        $user = User::find($id);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }

        if ($request->filled('role')) {
            $user->role = $validatedData['role'];
        }

        $user->save();

        return redirect()->back()->with('success', $user->name."'s account has been successfully updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Delete the user
            $user->delete();

            return redirect()->back()->with('success', 'User data has been successfully deleted.');
        } catch (\Exception $e) {
            // Handle any exceptions, such as database errors
            return redirect()->back()->with('error', 'Failed to delete user data. Please try again.');
        }
    }

    public function analytics()
    {
        return view('analytics');
    }

    public function unavailable()
    {
        return view('unavailable');
    }
}
