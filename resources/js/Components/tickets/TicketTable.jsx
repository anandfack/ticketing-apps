import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/Components/ui/table";

import { Link } from "@inertiajs/react";
import StatusBadge from "./StatusBadge";

export default function TicketTable({ tickets, user }) {
    return (
        <div className="border rounded-md">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>#</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Priority</TableHead>
                        <TableHead>Assigned</TableHead>
                        <TableHead className="text-right">Action</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    {tickets.data.map((ticket) => (
                        <TableRow key={ticket.id}>
                            <TableCell>#{ticket.id}</TableCell>
                            <TableCell>{ticket.title}</TableCell>

                            <TableCell>
                                <StatusBadge status={ticket.status} />
                            </TableCell>

                            <TableCell>{ticket.priority}</TableCell>

                            <TableCell>{ticket.assigned_to ?? "-"}</TableCell>

                            <TableCell className="text-right">
                                <Link href={`/tickets/${ticket.id}`}>View</Link>
                            </TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </div>
    );
}
