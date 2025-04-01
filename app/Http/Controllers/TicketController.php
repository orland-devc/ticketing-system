<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attachment;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function try_react()
    {
        return view('layouts.react.try_react');
    }

    public function getAssignedTickets()
    {
        $officeHead = Auth::user(); 
        $dumps = Ticket::where('assigned_to', $officeHead->id)
            ->get()
            ->sortByDesc('updated_at');

        $tickets = Ticket::with('user')
            ->whereIn('status', ['open', 'sent'])
            ->get()
            ->sortByDesc('updated_at');

        $assignedTickets = Ticket::where('assigned_to', $officeHead->id)
            ->where('status', 'open')
            ->get()
            ->sortByDesc('updated_at');

        $unreadTickets = Ticket::where('assigned_to', $officeHead->id)
            ->where('status', 'sent')
            ->get()
            ->sortByDesc('created_at');

        $closedTickets = Ticket::where('assigned_to', $officeHead->id)
            ->where('status', 'closed')
            ->get()
            ->sortByDesc('updated_at');

        $dumpsCount = Ticket::where('assigned_to', $officeHead->id)->count();
        $unreadTicketsCount = Ticket::where('assigned_to', $officeHead->id)->where('status', 'sent')->count();
        $closedTicketsCount = Ticket::where('assigned_to', $officeHead->id)->where('status', 'closed')->count();
        $assignedTicketsCount = Ticket::where('assigned_to', $officeHead->id)->where('status', 'open')->count();
        $allTickets = Ticket::where('assigned_to', $officeHead->id)->whereIn('status', ['open', 'sent'])->count();

        return view('show-assigned-tickets', compact('dumps', 'tickets', 'assignedTickets', 'closedTickets', 'unreadTickets', 'dumpsCount', 'unreadTicketsCount', 'closedTicketsCount', 'assignedTicketsCount', 'allTickets'));
    }

    public function getTicketCount()
    {
        $ticketCount = Ticket::count();

        return view('tickets', compact('ticketCount'));
    }

    public function returnToQueue(Ticket $ticket)
    {
        $ticket->update(['assigned_to' => null]);

        ActivityLog::log(
            'return_ticket',
            Auth::user()->name.' returned ticket #'.$ticket->id,
            Auth::user(),
            [
                'ticket_title' => $ticket->subject,
            ],
            $ticket 
        );

        return redirect()->route('tickets.index') // Redirect as needed
            ->with('message', 'The ticket has been successfully returned to the queue.');
    }

    public function viewMethod()
    {
        $getTicketCount = $this->getTicketCount();

        return view('tickets', compact('getTicketCount'));
    }

    public function index()
    {
        $oneYearAgo = now()->subYear();

        $dumps = Ticket::with('user')
            ->where('updated_at', '>=', $oneYearAgo)
            ->get()
            ->sortByDesc('updated_at');

        $tickets = Ticket::with('user')
            ->whereIn('status', ['open', 'sent'])
            ->where('updated_at', '>=', $oneYearAgo)
            ->get()
            ->sortByDesc('updated_at');

        $assignedTickets = Ticket::with('user')
            ->where('status', 'open')
            ->where('updated_at', '>=', $oneYearAgo)
            ->get()
            ->sortByDesc('updated_at');

        $unreadTickets = Ticket::with('user')
            ->where('status', 'sent')
            ->where('created_at', '>=', $oneYearAgo)
            ->get()
            ->sortByDesc('created_at');

        $closedTickets = Ticket::with('user')
            ->where('status', 'closed')
            ->where('updated_at', '>=', $oneYearAgo)
            ->get()
            ->sortByDesc('updated_at');

        $allTickets = Ticket::whereIn('status', ['open', 'sent'])
            ->where('updated_at', '>=', $oneYearAgo)
            ->count();

        return view('tickets', compact('dumps', 'tickets', 'assignedTickets', 'closedTickets', 'unreadTickets', 'allTickets'));
    }

    public function userIndex()
    {
        $categories = TicketCategory::all();

        $tickets = Ticket::where('sender_id', Auth::id())->get()->sortByDesc('created_at');

        $assignedTickets = Ticket::where('sender_id', Auth::id())
            ->whereIn('status', ['open', 'sent'])
            ->get()
            ->sortByDesc('created_at');

        $unreadTickets = Ticket::where('sender_id', Auth::id())
            ->where('status', 'sent')
            ->get()
            ->sortByDesc('created_at');

        $closedTickets = Ticket::where('sender_id', Auth::id())
            ->where('status', 'closed')
            ->get()
            ->sortByDesc('updated_at');

        $dumpsCount = Ticket::where('sender_id', Auth::id())->count();
        $unreadTicketsCount = Ticket::where('sender_id', Auth::id())->where('status', 'sent')->count();
        $closedTicketsCount = Ticket::where('sender_id', Auth::id())->where('status', 'closed')->count();
        $assignedTicketsCount = Ticket::where('sender_id', Auth::id())->where('status', 'open')->count();
        $allTickets = Ticket::where('sender_id', Auth::id())->whereIn('status', ['open', 'sent'])->count();

        return view('my-tickets', compact('categories', 'tickets', 'assignedTickets', 'unreadTickets', 'closedTickets', 'dumpsCount', 'unreadTicketsCount', 'closedTicketsCount', 'assignedTicketsCount', 'allTickets'));
    }

    public function create()
    {
        return view('add-ticket');
    }

    public function addUser()
    {
        $users = User::all();
        $admins = User::where('role', 'Administrator')->get();
        $offices = User::where('role', 'Office')->get();
        $students = User::where('role', 'Student')->get();
        $alumni = User::where('role', 'Alumni')->get();

        $usersCount = User::all()->count();
        $adminCount = User::where('role', 'Administrator')->count();
        $officeCount = User::where('role', 'Office')->count();
        $studentCount = User::where('role', 'Student')->count();
        $alumniCount = User::where('role', 'Alumni')->count();

        return view('add-user', compact('users', 'admins', 'offices', 'students', 'alumni', 'usersCount', 'adminCount', 'officeCount', 'studentCount', 'alumniCount'));
    }

    public function addUserForm(Request $request)
    {
        dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,office,student',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        $uploadsDirectory = 'images/uploads/';
        $request->validate([
            'attachments' => 'nullable|array',
            'attachments.*' => 'image|mimes:png,jpg,jpeg|max:10240',
        ]);

        $ticket = new Ticket();

        $ticket->subject = $request->subject === 'others' ? $request->other_subject : $request->subject;

        $ticket->category = $request->category === 'others' ? $request->other_category : $request->category;

        $ticket->content = $request->content;
        $ticket->level = $request->level;
        $ticket->sender_id = Auth::id();

        if ($request->assigned_office) {
            $assignedUser = User::where('name', $request->assigned_office)->first();
    
            if ($assignedUser) {
                $ticket->assigned_to = $assignedUser->id;
                $ticket->status = 'open';
            }
        }

        $ticket->save();

        ActivityLog::log(
            'ticket',
            Auth::user()->name.' submitted a ticket.',
            Auth::user(),
            [
                'ticket_title' => $ticket->subject,
            ],
            $ticket
        );

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();

                $path = $file->move($uploadsDirectory, $fileName);

                Attachment::create([
                    'sender_id' => Auth::id(),
                    'ticket_id' => $ticket->id,
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'file_location' => $uploadsDirectory.$fileName,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Ticket has been submitted successfully.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('attachments');

        return view('show', compact('ticket'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id); 
        $ticket->status = 'closed';
        $ticket->save();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Ticket has been CLOSED.',
            ]);
        }

        return back()->with('message', 'Ticket has been CLOSED.');
    }

    public function unread(Request $request, string $id)
    {
        $unread = Ticket::find($id);
        $unread->status = 'sent';
        $unread->assigned_to = null;
        $unread->save();

        ActivityLog::log(
            'return_ticket',
            Auth::user()->name.' returned ticket #'.$unread->id,
            Auth::user(),
            [
                'ticket_title' => $unread->subject,
            ],
        );

        return redirect()->back()->with('message', 'Ticket has been marked UNREAD.');
    }

    public function destroy(string $id)
    {
        //
    }

    public function showAssignForm(Ticket $ticket)
    {
        $users = User::where('role', 'Office')->get();

        return view('assign-ticket', compact('ticket', 'users'));
    }

    public function assignTicket(Request $request, Ticket $ticket)
    {
        $ticket->assigned_to = $request->assigned_to;
        $ticket->status = 'open';
        $ticket->save();

        session()->flash('message', 'The ticket has been assigned to '.$ticket->user->name.'.');

        return redirect()->back()->with('message', 'Ticket assigned successfully.');

    }

    public function fetchReplies($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        return view('_replies', compact('ticket'));
    }

    public function submitReply(Request $request, Ticket $ticket)
    {
        $uploadsDirectory = 'images/uploads/';

        $validatedData = $request->validate([
            'content' => 'required',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $routeName = $request->route()->getName();

        $routeUri = $request->route()->uri();

        $reply = new TicketReply([
            'ticket_id' => $ticket->id,
            'content' => $validatedData['content'],
            'assigned_to_id' => $ticket->assigned_to,
            'sender_id' => ($routeName === 'tickets.guest.verify' || $routeUri === 'tickets/guest/verify#')
                ? null
                : auth()->id(),
        ]);

        $reply->save();

        ActivityLog::log(
            'ticket_reply',
            Auth::user()->name.' replied to ticket #'.$ticket->id,
            Auth::user(),
            [
                'reply_id' => $reply->id,
            ],
            $ticket 
        );

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = $file->getClientOriginalName();

                $path = $file->move($uploadsDirectory, $fileName);

                Attachment::create([
                    'sender_id' => Auth::id(),
                    'ticket_reply_id' => $reply->id,
                    'file_name' => $fileName,
                    'file_location' => $uploadsDirectory.$fileName,
                ]);
            }
        }

        return response()->json(['message' => 'Reply submitted successfully']);
    }

    public function fetchUpdates($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        return view('_updates', compact('ticket'));

    }

    public function storeGuestTicket(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string|max:255|unique:tickets,guest_name',
            'guest_birthdate' => 'required|date',
            'guest_email' => 'nullable|email|unique:tickets,guest_email',
            'subject' => 'required|string',
            'category' => 'required|string',
            'content' => 'required|string',
            'level' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'image|mimes:png,jpg,jpeg|max:10240',
        ]);

        $ticket = new Ticket();
        $ticket->guest_name = $request->guest_name;
        $ticket->guest_birthdate = $request->guest_birthdate;
        $ticket->guest_email = $request->guest_email;
        $ticket->subject = $request->subject;
        $ticket->category = $request->category;
        $ticket->content = $request->content;
        $ticket->level = $request->level;

        $ticket->sender_id = null;

        $ticketCategory = TicketCategory::where('name', $request->category)->first();
        if ($ticketCategory && $ticketCategory->office_id) {
            $ticket->assigned_to = $ticketCategory->office_id;
            $ticket->status = 'open';
        } else {
            $ticket->status = 'Sent';
        }

        $ticket->save();

        $uploadsDirectory = 'images/uploads/';
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = uniqid().'_'.$file->getClientOriginalName();
                $fileSize = $file->getSize();

                $path = $file->move($uploadsDirectory, $fileName);

                Attachment::create([
                    'ticket_id' => $ticket->id,
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'file_location' => $uploadsDirectory.$fileName,
                ]);
            }
        }

        return redirect()->back()->with([
            'success' => 'Your ticket has been submitted successfully.',
        ]);
    }

    public function verifyGuestTicket(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string',
            'guest_birthdate' => 'required|date',
        ]);

        $ticket = Ticket::where('guest_name', $request->guest_name)
            ->where('guest_birthdate', $request->guest_birthdate)
            ->first();

        if (! $ticket) {
            return redirect()->back()->with('message', 'No tickets found.');
        }

        return view('tickets.guest.view', compact('ticket'));
    }

    public function trackGuestTicket(Request $request)
    {
        $request->validate([
            'tracking_token' => 'required|string',
            'birthdate' => 'required|date',
        ]);

        $ticket = Ticket::where('guest_tracking_token', $request->tracking_token)
            ->where('guest_birthdate', $request->birthdate)
            ->first();

        if (! $ticket) {
            return redirect()->back()->with('error', 'Invalid tracking details.');
        }

        $replies = TicketReply::where('ticket_id', $ticket->id)
            ->with('attachments')
            ->orderBy('created_at')
            ->get();

        return view('guest-ticket-details', compact('ticket', 'replies'));
    }
}
