<?php
namespace App\Http\Controllers;

use App\Models\SentEmail;
use Illuminate\Http\Request;

class SentEmailController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->sentEmails()->with(['client', 'emailJob']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('recipient_name', 'like', "%{$search}%")
                  ->orWhere('recipient_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $sentEmails = $query->latest()->paginate(20);

        return view('sent-emails.index', compact('sentEmails'));
    }

    public function show(SentEmail $sentEmail)
    {
        $this->authorize('view', $sentEmail);
        return view('sent-emails.show', compact('sentEmail'));
    }
}