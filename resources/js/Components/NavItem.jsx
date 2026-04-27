import { Link } from "@inertiajs/react";

export default function NavItem({ href, label }) {
    return (
        <Link
            href={href}
            className="block px-3 py-2 rounded-md hover:bg-gray-100 text-sm"
        >
            {label}
        </Link>
    );
}