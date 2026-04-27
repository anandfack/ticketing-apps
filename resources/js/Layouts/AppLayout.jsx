import { Button } from "@/Components/ui/button";
import { Link, usePage } from "@inertiajs/react";
import NavItem from "@/Components/NavItem";
import { hasPermission } from "@/lib/permission";

export default function AppLayout({ children }) {
    const { auth } = usePage().props;
    const user = auth.user;

    return (
        <>
            <div className="flex h-screen bg-gray-50">
                {/* SIDEBAR */}
                <aside className="w-64 bg-white border-r flex flex-col">
                    <div className="p-4 font-bold text-lg border-b">
                        🎫 Ticketing
                    </div>

                    <nav className="flex-1 p-3 space-y-1">
                        <NavItem href="/dashboard" label="Dashboard" />

                        {/* RBAC example */}
                        {hasPermission(user, "tickets.view") && (
                            <NavItem href="/tickets" label="Tickets" />
                        )}

                        {hasPermission(user, "users.manage") && (
                            <NavItem href="/users" label="Users" />
                        )}
                    </nav>
                </aside>

                {/* MAIN */}
                <div className="flex-1 flex flex-col">
                    {/* HEADER */}
                    <header className="h-14 bg-white border-b flex items-center justify-between px-4">
                        <h1 className="font-semibold">Dashboard</h1>

                        <div className="flex items-center gap-3">
                            {/* Notification placeholder */}
                            <Button variant="ghost">🔔</Button>

                            {/* Avatar */}
                            <div className="text-sm text-right">
                                <div className="font-medium">
                                    {user.full_name}
                                </div>
                                <div className="text-xs text-gray-500">
                                    {user.email}
                                </div>
                            </div>

                            {/* Logout */}
                            <Link href="/logout" method="post" as="button">
                                <Button variant="outline">Logout</Button>
                            </Link>
                        </div>
                    </header>

                    {/* CONTENT */}
                    <main className="flex-1 overflow-y-auto p-4">
                        {children}
                    </main>
                </div>
            </div>
        </>
    );
}
