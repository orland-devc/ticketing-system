<?php

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = User::where('role', 'Office')->get()->sortBy('name'); // Fetch office users
        $categories = TicketCategory::all();

        return view('create_ticket_category', compact('offices', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ticket_category,name',
            'office_id' => 'required|exists:users,id',
        ]);

        TicketCategory::create([
            'name' => $request->name,
            'office_id' => $request->office_id,
        ]);

        return redirect()->back()->with('message', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
