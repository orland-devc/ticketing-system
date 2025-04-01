<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get the current month
        $currentMonth = now()->month;
        $startDate = now()->subMonths(4)->startOfMonth();
        $endDate = now()->endOfMonth();

        // Fetch monthly user growth data for the last 4 months
        $userGrowth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(fn ($item) => $item->count);

        $ticketGrowth = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(fn ($item) => $item->count);

        // Fetch ticket category distribution for the last 4 months
        $ticketCategories = Ticket::selectRaw('category, MONTH(created_at) as month, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('category', 'month')
            ->orderBy('category')
            ->orderBy('month')
            ->get()
            ->groupBy('category');

        $categoryLabels = $ticketCategories->keys(); // Get the category names
        $categoryDatasets = [];

        // Prepare the data for each category
        foreach ($ticketCategories as $category => $data) {
            $categoryData = [];
            for ($i = 0; $i < 5; $i++) { // 4 months + current
                $month = $startDate->copy()->addMonths($i)->month;
                $ticketCount = $data->firstWhere('month', $month)?->count ?? 0;
                $categoryData[] = $ticketCount;
            }

            $categoryDatasets[] = [
                'label' => $category,
                'data' => $categoryData,
                'borderColor' => $this->randomColor(),
                'backgroundColor' => 'transparent',
                'borderWidth' => 2,
            ];
        }

        // Prepare arrays for the last 4 months with data
        $monthLabels = [];
        $monthDataUser = [];
        $monthDataTickets = [];

        for ($i = $currentMonth - 4; $i <= $currentMonth; $i++) {
            $month = ($i > 0) ? $i : $i + 12;
            $monthLabels[] = date('M', mktime(0, 0, 0, $month, 1));
            $monthDataUser[] = $userGrowth->get($month, 0); // Default to 0 if no user data
            $monthDataTickets[] = $ticketGrowth->get($month, 0); // Default to 0 if no ticket data
        }

        return view('admindashboard', [
            'monthLabels' => $monthLabels,
            'monthDataUser' => $monthDataUser,
            'monthDataTickets' => $monthDataTickets,
            'categoryLabels' => $categoryLabels,
            'categoryDatasets' => $categoryDatasets,
        ]);
    }

    // Helper function for random color
    private function randomColor()
    {
        $letters = '0123456789ABCDEF';
        $color = '#';
        for ($i = 0; $i < 6; $i++) {
            $color .= $letters[rand(0, 15)];
        }

        return $color;
    }
}
