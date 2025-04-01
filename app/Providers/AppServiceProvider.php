<?php

namespace App\Providers;

use App\Models\Chat;
use App\Models\ChatBotGreetings;
use App\Models\SignUpRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(512);

        // View::composer('messages.index', function ($view) {
        //     $authUserId = Auth::id();

        //     $contactss = Chat::where('sender_id', $authUserId)
        //         ->orWhere('receiver_id', $authUserId)
        //         ->orderBy('created_at', 'desc')
        //         ->get()
        //         ->unique(function ($chat) use ($authUserId) {
        //             return $chat->sender_id === $authUserId ? $chat->receiver_id : $chat->sender_id;
        //         });

        //     // Attach the last message and profile picture to each contact
        //     foreach ($contactss as $contact) {
        //         $otherUserId = $contact->sender_id === $authUserId ? $contact->receiver_id : $contact->sender_id;
        //         $contact->lastMessage = Chat::lastChatBetween($authUserId, $otherUserId);

        //         // Load the user model of the other user
        //         $contact->otherUser = User::find($otherUserId);
        //     }

        //     $view->with([
        //         'contacts' => $contactss,
        //     ]);
        // });

        View::composer(['layouts.navigation', 'layouts.navigations', 'layouts.officeNav', 'admindashboard', 'dashboard', 'show', 'add-user', 'officedashboard', 'messages.index', 'my-tickets'], function ($view) {
            $color = '#000';
            $users = User::all();
            $ticketList = Ticket::where('status', 'sent')->latest()->paginate(3);
            $allTickets = Ticket::all()->count();
            $openTickets = Ticket::where('status', 'open')->count();
            $unreadTickets = Ticket::where('status', 'sent')->count();
            $closedTickets = Ticket::where('status', 'closed')->count();

            $office_unread_tickets = Ticket::where('assigned_to', Auth::user()->id)->where('status', 'open')->count();
            $requestNum = SignUpRequest::where('approved', false)->count();
            $assignedTicketsCount = Ticket::where('sender_id', Auth::id())->where('status', ['open'])->count();

            $mySubmittedTicketsCount = Ticket::where('sender_id', Auth::id())->where('status', ['Sent'])->count();

            $myTotalTickets = $assignedTicketsCount + $mySubmittedTicketsCount;

            $officerUsers = User::where('role', 'office')->get();
            $adminCount = User::where('role', 'administrator')->count();
            $officeCount = User::where('role', 'office')->count();
            $studentCount = User::where('role', 'student')->count();
            $allUsers = User::all()->count();
            // $activeUsers = User::where('is_active', '1')->count();

            $assignedTicketss = Ticket::where('assigned_to', Auth::id())
                ->where('status', 'open')
                ->get()
                ->sortByDesc('updated_at');

            // Retrieve the most repeated category along with the count
            if (Ticket::exists()) {
                $mostRepeatedCategory = Ticket::selectRaw('category, COUNT(*) as count')
                    ->groupBy('category')
                    ->orderByRaw('COUNT(*) DESC')
                    ->first();
            }

            // Start building the array
            $viewData = [
                'color' => $color,
                'users' => $users,
                'ticket_list' => $ticketList,
                'all_tickets' => $allTickets,
                'officers' => $officerUsers,
                'open_tickets' => $openTickets,
                'unread_tickets' => $unreadTickets,
                'closed_tickets' => $closedTickets,
                'admin_count' => $adminCount,
                'office_count' => $officeCount,
                'student_count' => $studentCount,
                'total_users' => $allUsers,
                'office_unread_tickets' => $office_unread_tickets,
                'requestNum' => $requestNum,
                'assignedTicketsCount' => $assignedTicketsCount,
                'assignedTicketss' => $assignedTicketss,
                'mySubmittedTicketsCount' => $mySubmittedTicketsCount,
                'myTotalTickets' => $myTotalTickets,
            ];

            // Conditionally add 'top_category' and 'top_count' to the array if tickets exist
            if (isset($mostRepeatedCategory)) {
                $viewData['top_category'] = $mostRepeatedCategory->category;
                $viewData['top_count'] = $mostRepeatedCategory->count;
            }

            // Pass the array to the view
            $view->with($viewData);

        });

        View::composer(['officedashboard'], function ($view) {
            $assignedTickets = Ticket::where('assigned_to', Auth::id())->get()->sortByDesc('updated_at');
            $view->with([
                'assignedTickets' => $assignedTickets,
            ]);
        });

        View::composer([''], function ($view) {
            $assignedTickets = Ticket::where('assigned_to', Auth::id())->get();
            $view->with([
                'assignedTickets' => $assignedTickets,
            ]);
        });

        View::composer(['my-tickets'], function ($view) {
            $allTickets = Ticket::where('id', Auth::id());

            $view->with([
                'all_tickets' => $allTickets,
            ]);
        });

        View::composer(['my-tickets'], function ($view) {
            $allTickets = Ticket::where('sender_id', Auth::id())->get()->sortByDesc('updated_at');
            $view->with([
                'allTickets' => $allTickets,
            ]);
        });

        View::composer(['data_bank', 'manage-chatbot', 'chatbot-guest2'], function ($view) {
            $view->with([
                'botProfile' => ChatBotGreetings::where('type', 'profile_picture')->first(),
                'botName' => ChatBotGreetings::where('type', 'chatbot_name')->first(),
                'botGreeting' => ChatBotGreetings::where('type', 'greeting')->first(),
                'botFallback' => ChatBotGreetings::where('type', 'fallback')->first(),
                'botRepeated' => ChatBotGreetings::where('type', 'repeated')->first(),
            ]);
        });

        View::composer(['tickets'], function ($view) {
            $selectedTicket = Ticket::where('id', '86')->get();

            $view->with([
                'selectedTicket' => $selectedTicket, // Pass the selectedTicket to the view
            ]);
        });

    }
}
