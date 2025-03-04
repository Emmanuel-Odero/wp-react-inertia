import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Layout({ children, site, menu = [] }) {
  const { url } = usePage(); // Get the current URL from Inertia

  return (
    <div className="layout">
      <header>
        <h1>{site?.name || 'Site Name'}</h1>
        <nav>
          <ul>
            {menu.length > 0 ? (
              menu.map((item) => (
                <li key={item.url}>
                  <Link
                    href={item.url}
                    className={`nav-link ${url.startsWith(item.url) ? 'active' : ''}`}
                  >
                    {item.title}
                  </Link>
                </li>
              ))
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