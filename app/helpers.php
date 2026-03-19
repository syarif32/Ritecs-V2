<?php
if (!function_exists('public_assets_path')) {
    function public_assets_path($path = '')
    {
        // root di /sites
        return base_path('../public_html/sites') . ($path ? '/' . ltrim($path, '/') : $path);
    }
}
