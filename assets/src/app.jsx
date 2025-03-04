import './app.css';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import Layout from './components/Layout';

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./pages/**/*.jsx', { eager: true });
    
    const pagePath = `./pages/${name}.jsx`;
    const page = pages[pagePath] || pages[`./pages/index.jsx`] || pages[`./pages/404.jsx`]; // Added 404 fallback
    
    if (!page) {
      throw new Error(`Page not found: ${name}. No fallback available`);
    }
    
    const component = page.default;
    component.layout = (page) => <Layout {...page.props}>{page}</Layout>;
    return component;
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />);
  },
});