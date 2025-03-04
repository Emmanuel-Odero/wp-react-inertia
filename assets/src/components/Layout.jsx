import React from "react";
import { Link, usePage } from "@inertiajs/react";

export default function Layout({ children, site, menu = [] }) {
  const { url } = usePage(); 
  return (
    <div className="layout">
      <header>
        <h1>{site?.name || 'Site Name'}</h1>
        <nav>
          <ul>
            {menu.length > 0 ? (
              menu.map((item) => {
                const itemPath = new URL(item.url, window.location.origin)
                  .pathname;

                return (
                  <li key={item.url}>
                    <Link
                      href={item.url}
                      className={
                        itemPath === url ? "nav-link active" : "nav-link"
                      }
                    >
                      {item.title}
                    </Link>
                  </li>
                );
              })
            ) : (
              <li>No menu items available</li>
            )}
          </ul>
        </nav>
      </header>
      <main>{children}</main>
    </div>
  );
}
