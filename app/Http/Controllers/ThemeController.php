<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{
    /**
     * Toggle the theme between dark and light mode
     */
    public function toggle(Request $request): JsonResponse
    {
        $currentTheme = $request->session()->get('theme', 'dark');
        $newTheme = $currentTheme === 'dark' ? 'light' : 'dark';
        
        $request->session()->put('theme', $newTheme);
        
        return response()->json([
            'success' => true,
            'theme' => $newTheme,
            'message' => __('messages.theme_switched', ['theme' => __("messages.{$newTheme}_mode")])
        ]);
    }

    /**
     * Set a specific theme
     */
    public function setTheme(Request $request): JsonResponse
    {
        $request->validate([
            'theme' => 'required|in:dark,light'
        ]);

        $theme = $request->input('theme');
        $request->session()->put('theme', $theme);

        return response()->json([
            'success' => true,
            'theme' => $theme,
            'message' => __('messages.theme_set', ['theme' => __("messages.{$theme}_mode")])
        ]);
    }

    /**
     * Get the current theme
     */
    public function getCurrentTheme(Request $request): JsonResponse
    {
        $theme = $request->session()->get('theme', 'dark');
        
        return response()->json([
            'theme' => $theme
        ]);
    }
}
