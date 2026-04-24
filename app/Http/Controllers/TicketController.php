<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;
    /*
    |--------------------------------------
    | LIST TICKETS (WITH SCOPING)
    |--------------------------------------
    */

    public function index(Request $request)
    {
        $user = $request->user();

        $query = Ticket::query();

        // REQUESTER → only own tickets
        if ($user->hasRole('requester')) {
            $query->where('created_by', $user->id);
        }

        // AGENT → only assigned tickets
        if ($user->hasRole('agent')) {
            $query->where('assigned_to', $user->id);
        }

        // SUPERVISOR → all tickets (no filter)

        // ADMIN → all tickets

        $tickets = $query->latest()->get();

        return inertia('Tickets/Index', [
            'tickets' => $tickets
        ]);
    }

    /*
    |--------------------------------------
    | SHOW SINGLE TICKET
    |--------------------------------------
    */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return inertia('Tickets/Show', [
            'ticket' => $ticket
        ]);
    }

    /*
    |--------------------------------------
    | CREATE FORM
    |--------------------------------------
    */
    public function create()
    {
        $this->authorize('create', Ticket::class);

        return inertia('Tickets/Create');
    }

    /*
    |--------------------------------------
    | STORE TICKET
    |--------------------------------------
    */
    public function store(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $validated = $request->validate([
            'title' => 'required|string|max:250',
            'description' => 'nullable|string',
        ]);

        $ticket = Ticket::create([
            'ticket_number' => 'TKT-' . now()->format('YmdHis'),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'created_by' => $request->user()->id,
            'status' => 'open',
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    /*
    |--------------------------------------
    | UPDATE TICKET
    |--------------------------------------
    */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->only([
            'title',
            'description',
            'status',
        ]));

        return back();
    }

    /*
    |--------------------------------------
    | ASSIGN TICKET (SUPERVISOR / ADMIN)
    |--------------------------------------
    */
    public function assign(Request $request, Ticket $ticket)
    {
        $this->authorize('assign', $ticket);

        $ticket->update([
            'assigned_to' => $request->user_id,
        ]);

        return back();
    }

    /*
    |--------------------------------------
    | DELETE TICKET (ADMIN ONLY)
    |--------------------------------------
    */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return back();
    }
}
