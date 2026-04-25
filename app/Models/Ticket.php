<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ticket extends Model
{
    use LogsActivity;

    protected $fillable = [
        'ticket_number',
        'title',
        'description',
        'created_by',
        'assigned_to',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('ticket')
            ->logOnly(['title', 'description', 'assigned_to', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return match ($eventName) {
            'created' => "Ticket created",
            'updated' => "Ticket updated",
            'deleted' => "Ticket deleted",
            default => "Ticket event: {$eventName}",
        };
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $this->authorize('assign', $ticket);

        $old = $ticket->assigned_to;

        $ticket->update([
            'assigned_to' => $request->user_id,
        ]);

        activity('ticket')
            ->performedOn($ticket)
            ->causedBy($request->user())
            ->withProperties([
                'old_assigned_to' => $old,
                'new_assigned_to' => $request->user_id,
            ])
            ->log('Ticket assigned');

        return back();
    }
}
