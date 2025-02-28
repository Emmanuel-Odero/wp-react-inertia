<?php
namespace Inertia;

class Inertia {
    private static $shared = [];
    private static $version = '1.0';

    // Share global data
    public static function share($key, $value = null) {
        if (is_array($key)) {
            self::$shared = array_merge(self::$shared, $key);
        } else {
            self::$shared[$key] = $value;
        }
    }

    // Render an Inertia page
    public static function render($component, $props = []) {
        if (self::isInertiaRequest()) {
            // Set Inertia headers
            header('X-Inertia: true');
            header('Content-Type: application/json');
            header('Vary: Accept');

            // Send JSON response
            echo json_encode(self::buildResponse($component, $props));
            exit;
        }

        // For first load, render the root template
        add_filter('template_include', fn() => get_template_directory() . '/index.php');
    }

    // Check if this is an Inertia XHR request
    private static function isInertiaRequest() {
        return isset($_SERVER['HTTP_X_INERTIA']) && $_SERVER['HTTP_X_INERTIA'] === 'true';
    }

    // Build the JSON response for Inertia
    private static function buildResponse($component, $props) {
        return [
            'component' => $component,
            'props' => array_merge(self::$shared, $props),
            'url' => $_SERVER['REQUEST_URI'],
            'version' => self::$version,
        ];
    }

    // Get the root view HTML (for SSR or first load)
    public static function getRootView() {
        ob_start();
        include get_template_directory() . '/index.php';
        return ob_get_clean();
    }
}