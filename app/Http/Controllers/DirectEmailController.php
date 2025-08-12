<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\SentEmail;
use App\Mail\DirectEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DirectEmailController extends Controller
{
    /**
     * Display a listing of sent direct emails.
     */
    public function index()
    {
        // Ensure the type column exists
        if (!Schema::hasColumn('sent_emails', 'type')) {
            Schema::table('sent_emails', function (Blueprint $table) {
                $table->enum('type', ['campaign', 'direct'])->default('campaign')->after('id');
            });
        }

        // Use the scopes from the model
        $emails = SentEmail::direct()
            ->forCurrentUser()
            ->with('client')
            ->latest()
            ->paginate(15);

        return view('direct-emails.index', compact('emails'));
    }

    /**
     * Show the form for creating a new direct email.
     */
    public function create()
    {
        $clients = Client::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('direct-emails.create', compact('clients'));
    }

    /**
     * Send a direct email to the specified client.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $client = Client::findOrFail($request->client_id);
        
        // Create a record in sent_emails
        $sentEmail = SentEmail::create([
            'user_id' => auth()->id(),
            'client_id' => $client->id,
            'subject' => $request->subject,
            'content' => $request->content,
            'type' => 'direct',
            'status' => 'pending',
            'sent_at' => now(),
        ]);

        try {
            // Send the email
            Mail::to($client->email)
                ->send(new DirectEmail($client, $request->content, $request->subject));
            
            // Update status to sent
            $sentEmail->update(['status' => 'sent']);
            
            return redirect()->route('direct-emails.show', $sentEmail->id)
                ->with('success', 'Email sent successfully!');
                
        } catch (\Exception $e) {
            $sentEmail->update([
                'status' => 'failed',
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified sent email.
     */
    public function show(string $id)
    {
        $email = SentEmail::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('client')
            ->firstOrFail();

        return view('direct-emails.show', compact('email'));
    }
}
