<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tickets = collect();

        if ($user->hasRole('Super Admin')) {
            $tickets = SupportTicket::with(['user', 'forwardedTo'])->latest()->get();
        } elseif ($user->hasRole('Admin') || $user->hasRole('Cleaner')) {
            $tickets = SupportTicket::with(['user', 'forwardedTo'])
                ->where('forwarded_to_user_id', $user->id)
                ->latest()
                ->get();
        } else {
            $tickets = SupportTicket::with(['forwardedTo'])->where('user_id', $user->id)->latest()->get();
        }

        // Get potential agents for forwarding
        $admins = User::role('Admin')->get();
        $cleaners = User::role('Cleaner')->get();
        $agents = $admins->concat($cleaners);

        if ($user->hasRole('Admin')) {
            $agents = $cleaners; // Admins can only forward to cleaners
        }

        $faqs = Faq::orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('support.index', compact('tickets', 'agents', 'faqs'));
    }

    public function storeFaq(Request $request)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        Faq::create($request->all());

        return redirect()->back()->with('success', 'FAQ added successfully.');
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $faq->update($request->all());

        return redirect()->back()->with('success', 'FAQ updated successfully.');
    }

    public function destroyFaq(Faq $faq)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        $faq->delete();

        return redirect()->back()->with('success', 'FAQ deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => 'Open',
        ]);

        return redirect()->back()->with('success', 'Support ticket submitted successfully.');
    }

    public function forward(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'forwarded_to_user_id' => $request->agent_id,
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Ticket forwarded successfully.');
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:Open,Pending,Closed',
        ]);

        $ticket->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Ticket status updated successfully.');
    }
}
