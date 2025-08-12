<?php


namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\EmailJob;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailCampaignController extends Controller
{
    public function create()
    {
        $clients = auth()->user()->clients()->orderBy('name')->get();
        $templates = auth()->user()->emailTemplates()->orderBy('name')->get();
        
        return view('email-campaigns.create', compact('clients', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:template,custom',
            'template_id' => 'required_if:type,template|exists:email_templates,id',
            'custom_subject' => 'required_if:type,custom|string|max:255',
            'custom_body' => 'required_if:type,custom|string',
            'recipient_ids' => 'required|array|min:1',
            'recipient_ids.*' => 'exists:clients,id',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $user = auth()->user();

        // Verify all recipients belong to the user
        $validRecipients = $user->clients()
            ->whereIn('id', $request->recipient_ids)
            ->pluck('id')
            ->toArray();

        if (count($validRecipients) !== count($request->recipient_ids)) {
            return back()->withErrors(['recipient_ids' => 'Invalid recipients selected.']);
        }

        $data = [
            'type' => $request->type,
            'recipient_ids' => $validRecipients,
            'scheduled_at' => $request->scheduled_at,
            'user_id' => $user->id,
        ];

        if ($request->type === 'template') {
            $template = $user->emailTemplates()->findOrFail($request->template_id);
            $data['template_id'] = $template->id;
            $data['subject'] = $template->subject;
            $data['body'] = $template->body;
        } else {
            $data['subject'] = $request->custom_subject;
            $data['body'] = $request->custom_body;
        }

        EmailJob::create($data);

        return redirect()->route('email-campaigns.index')
            ->with('success', 'Email campaign scheduled successfully.');
    }

    public function index()
    {
        $emailJobs = auth()->user()->emailJobs()
            ->with('template')
            ->latest()
            ->paginate(15);

        return view('email-campaigns.index', compact('emailJobs'));
    }

    public function show(EmailJob $emailJob)
    {
        $this->authorize('view', $emailJob);
        
        $recipients = Client::whereIn('id', $emailJob->recipient_ids ?? [])->get();
        $sentEmails = $emailJob->sentEmails()->with('client')->latest()->paginate(20);
        
        return view('email-campaigns.show', compact('emailJob', 'recipients', 'sentEmails'));
    }

    public function destroy(EmailJob $emailJob)
    {
        $this->authorize('delete', $emailJob);
        
        if ($emailJob->status !== 'pending') {
            return back()->withErrors(['error' => 'Cannot delete a campaign that has been processed.']);
        }
        
        $emailJob->delete();

        return redirect()->route('email-campaigns.index')
            ->with('success', 'Email campaign deleted successfully.');
    }
}
