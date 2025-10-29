import "./app.css";
import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import Layout from "./components/Layout";

// Add HMR debug logging
if (import.meta.hot) {
  import.meta.hot.on("vite:beforeUpdate", () => {
    console.log("vite:beforeUpdate");
  });
}

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob("./pages/*.jsx", { eager: true });
    console.log("Available pages:", Object.keys(pages));
    console.log("Requested page:", `./pages/${name}.jsx`);

    const page = pages[`./pages/${name}.jsx`] || pages[`./pages/index.jsx`]; // Fallback to index
    if (!page) {
      throw new Error(`Page not found: ${name}`);
    }

    const component = page.default;
    if (!component) {
      throw new Error(`No default export in ${name}.jsx`);
    }

    component.layout = (page) => <Layout {...page.props}>{page}</Layout>;
    return component;
  },
  setup({ el, App, props }) {
    createRoot(el).render(<App {...props} />);
  },
});
