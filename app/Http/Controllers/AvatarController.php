<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AvatarController extends Controller
{
    /**
     * Upload user avatar.
     */
    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.validation_error'),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = auth()->user();
            
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Generate unique filename
            $file = $request->file('avatar');
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Resize and save image
            $image = Image::make($file);
            $image->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Create circle mask for avatar
            $image->fit(200, 200);
            
            // Save to storage
            $path = 'avatars/' . $filename;
            Storage::disk('public')->put($path, $image->encode());
            
            // Update user avatar
            $user->update(['avatar' => $filename]);
            
            return response()->json([
                'success' => true,
                'message' => __('messages.avatar_uploaded_successfully'),
                'avatar_url' => $user->avatar_url,
                'avatar_filename' => $filename
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.avatar_upload_failed'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove user avatar.
     */
    public function remove(): JsonResponse
    {
        try {
            $user = auth()->user();
            
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
                $user->update(['avatar' => null]);
            }
            
            return response()->json([
                'success' => true,
                'message' => __('messages.avatar_removed_successfully'),
                'avatar_url' => $user->avatar_url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('messages.avatar_remove_failed'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user avatar info.
     */
    public function info(): JsonResponse
    {
        $user = auth()->user();
        
        return response()->json([
            'success' => true,
            'avatar_url' => $user->avatar_url,
            'has_custom_avatar' => !is_null($user->avatar),
            'initials' => $user->initials
        ]);
    }
}