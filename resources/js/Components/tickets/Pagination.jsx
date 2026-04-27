import { Link } from "@inertiajs/react";

export default function Pagination({ meta }) {
  return (
    <div className="flex gap-2 mt-4">
      {meta.links.map((link, i) => (
        <Link
          key={i}
          href={link.url ?? ""}
          className={`px-3 py-1 border rounded ${
            link.active ? "bg-black text-white" : ""
          }`}
          dangerouslySetInnerHTML={{ __html: link.label }}
        />
      ))}
    </div>
  );
}