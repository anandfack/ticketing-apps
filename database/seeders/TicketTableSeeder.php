<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMIN USER
        $admin = Ticket::create([
            'ticket_number' => 'TICKET-0001',
            'title' => 'Sample Ticket',
            'description' => 'This is a sample ticket created by the seeder.',
            'status' => 'open',
            'created_by' => 1, // Assuming the admin user has ID 1
            // 'priority' => 'medium',
            'assigned_to' => null,
        ]);

        // $admin->assignRole('admin');
    }
}
