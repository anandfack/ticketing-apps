<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /*
    |--------------------------------------
    | VIEW LIST / INDEX
    |--------------------------------------
    */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('supervisor')) return true;

        if ($user->hasRole('agent')) return true;

        if ($user->hasRole('requester')) return true;

        return false;
    }

    /*
    |--------------------------------------
    | VIEW SINGLE TICKET
    |--------------------------------------
    */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('supervisor')) return true;

        if ($user->hasRole('agent')) {
            return $ticket->assigned_to === $user->id;
        }

        if ($user->hasRole('requester')) {
            return $ticket->created_by === $user->id;
        }

        return false;
    }

    /*
    |--------------------------------------
    | CREATE TICKET
    |--------------------------------------
    */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'requester']);
    }

    /*
    |--------------------------------------
    | UPDATE TICKET
    |--------------------------------------
    */
    public function update(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('supervisor')) return true;

        if ($user->hasRole('agent')) {
            return $ticket->assigned_to === $user->id;
        }

        return false;
    }

    /*
    |--------------------------------------
    | DELETE TICKET
    |--------------------------------------
    */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }

    /*
    |--------------------------------------
    | ASSIGN / REASSIGN TICKET
    |--------------------------------------
    */
    public function assign(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('supervisor')) return true;

        return false;
    }

    /*
    |--------------------------------------
    | COMMENT
    |--------------------------------------
    */
    public function comment(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('supervisor')) return true;

        if ($user->hasRole('agent')) {
            return $ticket->assigned_to === $user->id;
        }

        if ($user->hasRole('requester')) {
            return $ticket->created_by === $user->id;
        }

        return false;
    }

    /*
    |--------------------------------------
    | SLA OVERRIDE (SPECIAL RULE)
    |--------------------------------------
    */
    public function overrideSla(User $user, Ticket $ticket): bool
    {
        return $user->hasAnyRole(['admin', 'supervisor']);
    }
}