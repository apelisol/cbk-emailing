<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\EmailJob;
use App\Models\SentEmail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_clients' => $user->clients()->count(),
            'sent_emails' => $user->sentEmails()->where('status', 'sent')->count(),
            'pending_emails' => $user->sentEmails()->where('status', 'pending')->count(),
            'failed_emails' => $user->sentEmails()->where('status', 'failed')->count(),
            'upcoming_scheduled' => $user->emailJobs()
                ->where('status', 'pending')
                ->where('scheduled_at', '>', now())
                ->count(),
        ];

        $recentSentEmails = $user->sentEmails()
            ->with('client')
            ->latest()
            ->take(10)
            ->get();

        $upcomingEmails = $user->emailJobs()
            ->where('status', 'pending')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentSentEmails', 'upcomingEmails'));
    }
}