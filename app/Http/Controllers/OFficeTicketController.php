<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class OFficeTicketController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('office-show', compact('ticket'));
    }

    public function showUserTicketDetails(Ticket $ticket)
    {
        return view('user-show', compact('ticket'));
    }

    public function showOfficeTicketDetails(Ticket $ticket)
    {
        return view('office-show', compact('ticket'));
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

    public function reply(Request $request, Ticket $ticket)
    {
        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        $reply = new TicketReply([
            'ticket_id' => $ticket->id,
            'parent_message_id' => $ticket->id,
            'content' => $validatedData['content'],
            'assigned_to_id' => $ticket->assigned_to,
            'sender_id' => auth()->id(),
        ]);

        $reply->save();

        return redirect()->back();
    }
}
