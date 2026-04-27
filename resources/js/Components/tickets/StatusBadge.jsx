export default function StatusBadge({ status }) {
    const styles = {
        open: "bg-blue-100 text-blue-700",
        in_progress: "bg-yellow-100 text-yellow-700",
        closed: "bg-green-100 text-green-700",
        rejected: "bg-red-100 text-red-700",
    };

    const label = {
        open: "Open",
        in_progress: "In Progress",
        closed: "Closed",
        rejected: "Rejected",
    };

    return (
        <span
            className={`px-2 py-1 text-xs font-medium rounded ${styles[status] ?? "bg-gray-100 text-gray-600"}`}
        >
            {label[status] ?? status}
        </span>
    );
}