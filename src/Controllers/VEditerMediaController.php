<?php

namespace BblStudio\BblStudio\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class VEditerMediaController extends Controller
{
    /**
     * Sanitize a given path by removing unwanted characters.
     *
     * @param string $path
     * @return string
     */
    public function sanitizePath($path)
    {
        // Sanitize the path to prevent directory traversal and other invalid characters
        return preg_replace(
            '@/+@', DIRECTORY_SEPARATOR,
            preg_replace(
                '@\?.*$@', '', // Remove query parameters
                preg_replace(
                    '@\.{2,}@', '', // Remove any instances of double dots (..) for security
                    preg_replace('@[^\/\\a-zA-Z0-9\-\._]@', '', $path) // Allow only valid characters
                )
            )
        );
    }

    /**
     * Scan a directory recursively and return the structure as JSON.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function scanMedia(Request $request)
    {
        // Get media path from the request, otherwise default to 'veditor/media'
        $mediaPath = $request->input('mediaPath') ?? 'veditor/media';
        $sanitizedPath = $this->sanitizePath(substr($mediaPath, 0, 256));

        // Define the upload path (relative to storage/public)
        $uploadPath = storage_path('app/public/' . $sanitizedPath);

        // Run the scan recursively
        $response = $this->scanDirectory($uploadPath);

        // Return the directory structure as JSON
        return response()->json([
            'name'  => '',
            'type'  => 'folder',
            'path'  => '',
            'items' => $response,
        ]);
    }
    public function deleteMedia(Request $request)
    {
        // Get media path from the request
        $mediaPath = $request->input('mediaPath');

        $sanitizedPath = $this->sanitizePath(substr($mediaPath, 0, 256));

        // Define the upload path (relative to storage/public)
        $uploadPath = storage_path('app/public/' . $sanitizedPath);

        // Check if the file or directory exists
        if (!File::exists($uploadPath)) {
            return response()->json([
                'success' => false,
                'message' => 'File or directory does not exist.',
            ], 404);
        }

        // Delete the file or directory
        try {
            if (File::isDirectory($uploadPath)) {
                // If it's a directory, delete it recursively
                File::deleteDirectory($uploadPath);
            } else {
                // If it's a file, delete it
                File::delete($uploadPath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Media deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete media: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function renameMedia(Request $request)
    {
        // Get media path and new name from the request
        $mediaPath = $request->input('mediaPath');
        $newName = $request->input('newName');

        // Sanitize the media path to avoid potential security issues
        $sanitizedPath = $this->sanitizePath(substr($mediaPath, 0, 256));

        // Define the upload path (relative to storage/public)
        $uploadPath = storage_path('app/public/' . $sanitizedPath);

        // Check if the file exists
        if (!File::exists($uploadPath)) {
            return response()->json([
                'success' => false,
                'message' => 'File does not exist.',
            ], 404);
        }

        // Get the directory path and new file name
        $directory = dirname($uploadPath);
        $newFilePath = $directory . '/' . $newName;

        // Check if a file with the new name already exists
        if (File::exists($newFilePath)) {
            return response()->json([
                'success' => false,
                'message' => 'A file with the new name already exists.',
            ], 409);
        }

        // Attempt to rename the file
        try {
            File::move($uploadPath, $newFilePath);

            return response()->json([
                'success' => true,
                'message' => 'Media renamed successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to rename media: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Recursively scan the directory for files and folders.
     *
     * @param string $dir
     * @return array
     */
    private function scanDirectory($dir)
    {
        $files = [];

        // Check if the directory exists
        if (File::exists($dir)) {
            foreach (File::directories($dir) as $folder) {
                $folderName = basename($folder);

                $files[] = [
                    'name'  => $folderName,
                    'type'  => 'folder',
                    'path'  => '/storage' . str_replace(storage_path('app/public'), '', $folder),
                    'items' => $this->scanDirectory($folder),
                ];
            }

            // Get all the files in the directory
            foreach (File::files($dir) as $file) {
                $fileName = $file->getFilename();
                $filePath = '/storage' . str_replace(storage_path('app/public'), '', $file->getPathname());

                // Ensure the file path does not have duplicated '/storage' prefix
                $filePath = str_replace('/storage/storage', '/storage', $filePath);

                $files[] = [
                    'name' => $fileName,
                    'type' => 'file',
                    'path' => '/'.$fileName,
                    'size' => $file->getSize(), // File size in bytes
                ];
            }
        }

        return $files;
    }
}
