import React from 'react';
import { Link } from '@inertiajs/react';

export default function Layout({ children, site, menu = [] }) {
  return (
    <div className="layout">
      <header>
        <h1>{site?.name || 'Site Name'}</h1>
        <nav>
          <ul>
            {menu.length > 0 ? (
              menu.map((item) => (
                <li key={item.url}>
                  <Link href={item.url} className="nav-link">
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