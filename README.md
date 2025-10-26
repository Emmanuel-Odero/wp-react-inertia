# WordPress Inertia React Starter Theme
A lightweight WordPress starter theme integrating Inertia.js with React for a modern SPA-like experience.

## Author
- Created by Emmanuel Oder emmanuelodero@techmates.team
- GitHub: [Emmanuel-Odero](https://github.com/Emmanuel-Odero)

## License
This project is open-source under the [MIT License](LICENSE).

## Features
- WordPress as the CMS backend.
- Inertia.js for client-side routing.
- React for the frontend UI.
- Vite for fast builds.

## Installation
1. Clone the repo: `git clone https://github.com/Emmanuel-Odero/wp-react-inertia.git`
2. Install PHP dependencies: `composer install` (if you add any).
3. Install JS dependencies: `npm install`
4. Build assets: `npm run build`
5. Place in `wp-content/themes/` and activate in WordPress admin.

## Contributing
See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Usage
- Create pages/posts in WordPress admin.
- Menus are rendered dynamically via the "Primary" location.

## Folder Structure
wordpress-inertia-react-starter/
    ├── assets/
    │   ├── src/
    │   │   ├── components/
    │   │   │   └── Layout.jsx
    │   │   ├── pages/
    │   │   │   └── Content.jsx
    │   │   ├── app.jsx
    │   │   └── app.css
    │   └── build/ (ignored)
    ├── lib/
    │   └── inertia/
    │       └── Inertia.php
    ├── functions.php
    ├── index.php
    ├── style.css
    ├── package.json
    ├── vite.config.js
    ├── .gitignore
    ├── README.md
    ├── LICENSE
    └── CONTRIBUTING.md