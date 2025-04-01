<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
// use Illuminate\Support\Carbon;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    //
    public function formatTime($hours)
    {
        return $hours >= 24
            ? number_format($hours / 24, 1).'d'
            : number_format($hours, 1).'h';
    }

    public function index()
    {
        $currentMonth = Carbon::now()->format('F Y');
        $monthlyUsers = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $officeStaffTickets = User::where('role', 'Office')
            ->withCount('assignedTickets')
            ->orderByDesc('assigned_tickets_count')
            ->limit(4)
            ->get();

        $total = Ticket::with('user')
            ->get()
            ->sortByDesc('updated_at');

        $resolved = Ticket::with('user')
            ->where('status', 'closed')
            ->get()
            ->sortByDesc('updated_at');

        $resolution_hours = Ticket::with('user')
            ->where('status', 'closed')
            ->get()
            ->avg(function ($ticket) {
                $created = Carbon::parse($ticket->created_at);
                $closed = Carbon::parse($ticket->updated_at);

                return $created->diffInHours($closed, true);
            });

        $resolution_time = $resolution_hours >= 24
            ? number_format($resolution_hours / 24, 1).' days'
            : number_format($resolution_hours, 1).'h';

        $responseTimeRankings = User::where('role', 'Office')
            ->withCount('assignedTickets')
            ->with(['assignedTickets.Replies' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->get()
            ->map(function ($user) {
                $totalResponseTime = 0;
                $ticketsWithResponses = 0;

                foreach ($user->assignedTickets as $ticket) {
                    $firstResponse = $ticket->Replies()
                        ->where('sender_id', $user->id)
                        ->first();

                    if ($firstResponse && $ticket->created_at && $firstResponse->created_at) {
                        $created = Carbon::parse($ticket->created_at);
                        $responded = Carbon::parse($firstResponse->created_at);
                        $diffInHours = $created->diffInHours($responded, true);

                        if ($diffInHours > 0) {
                            $totalResponseTime += $diffInHours;
                            $ticketsWithResponses++;
                        }
                    }
                }

                return [
                    'name' => $user->name,
                    'avg_response_time' => $ticketsWithResponses > 0 ? $totalResponseTime / $ticketsWithResponses : null,
                    'tickets_count' => $ticketsWithResponses,
                ];
            })
            ->filter(function ($user) {
                return $user['avg_response_time'] !== null;
            })
            ->sortBy('avg_response_time')
            ->values()
            ->take(4);

        // Calculate overall average response time
        $allResponseTimes = User::where('role', 'Office')
            ->with(['assignedTickets.Replies' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->get()
            ->reduce(function ($carry, $user) {
                $userTotalResponseTime = 0;
                $userTicketsWithResponses = 0;

                foreach ($user->assignedTickets as $ticket) {
                    $firstResponse = $ticket->Replies()
                        ->where('sender_id', $user->id)
                        ->first();

                    if ($firstResponse && $ticket->created_at && $firstResponse->created_at) {
                        $created = Carbon::parse($ticket->created_at);
                        $responded = Carbon::parse($firstResponse->created_at);
                        $diffInHours = $created->diffInHours($responded, true);

                        if ($diffInHours > 0) {
                            $userTotalResponseTime += $diffInHours;
                            $userTicketsWithResponses++;
                        }
                    }
                }

                $carry['totalResponseTime'] += $userTotalResponseTime;
                $carry['totalTickets'] += $userTicketsWithResponses;

                return $carry;
            }, ['totalResponseTime' => 0, 'totalTickets' => 0]);

        $overallAvgResponseTime = $allResponseTimes['totalTickets'] > 0
            ? $allResponseTimes['totalResponseTime'] / $allResponseTimes['totalTickets']
            : null;

        // Get the user with the most returned tickets
        $mostReturnedTickets = ActivityLog::where('type', 'return_ticket')
            ->selectRaw('user_id, COUNT(*) as return_count')
            ->groupBy('user_id')
            ->orderByDesc('return_count')
            ->first();

        $userWithMostReturns = $mostReturnedTickets
            ? User::find($mostReturnedTickets->user_id)->name
            : 'N/A';

        $totalReturns = $mostReturnedTickets->return_count ?? 0;

        // Return view
        return view('analytics', compact(
            'total',
            'resolved',
            'resolution_time',
            'monthlyUsers',
            'currentMonth',
            'officeStaffTickets',
            'responseTimeRankings',
            'overallAvgResponseTime',
            'userWithMostReturns',
            'totalReturns'
        ));
    }
}
