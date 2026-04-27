import AppLayout from "@/Layouts/AppLayout";
import TicketTable from "@/Components/tickets/TicketTable";
import { usePage } from "@inertiajs/react";

export default function Index({ tickets }) {
    const { auth } = usePage().props;

    return (
        <div>
            <h1 className="text-xl font-bold mb-4">Tickets</h1>

            <TicketTable tickets={tickets} user={auth.user} />
        </div>
    );
}

Index.layout = (page) => <AppLayout children={page} />;
