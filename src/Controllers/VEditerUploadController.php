<?php

namespace BblStudio\BblStudio\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class VEditerUploadController extends Controller
{
    /**
     * Handle the file upload request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        // Define allowed file extensions
        $allowedExtensions = ['ico', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $deniedExtensions = ['php'];

        $request->validate([
            'file' => 'required|file|mimes:' . implode(',', $allowedExtensions) . '|max:5120', // 5MB max
            'mediaPath' => 'nullable|string|max:255',
        ]);

        // Sanitize the file name
        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $sanitizedFileName = $this->sanitizeFileName($originalFileName);
        $extension = strtolower($file->getClientOriginalExtension());

        // Check if the extension is denied
        if (in_array($extension, $deniedExtensions)) {
            return response()->json(['error' => "File type $extension not allowed!"], 400);
        }

        // Define the upload path
        $mediaPath = $request->input('mediaPath', 'uploads');
        $uploadPath = Str::finish($mediaPath, '/');

        // Store the file
        $filePath = $file->storeAs($uploadPath, $sanitizedFileName, 'public');

        // Return the file name or file path
        $onlyFilename = $request->input('onlyFilename', false);
        $response = $onlyFilename ? $sanitizedFileName : Storage::url($filePath);

        return response()->json(['file' => $response], 200);
    }

    /**
     * Sanitize the file name by removing unwanted characters and spaces.
     *
     * @param string $fileName
     * @return string
     */
    private function sanitizeFileName($fileName)
    {
        $disallowed = ['.htaccess', 'passwd'];
        $fileName = str_replace($disallowed, '', $fileName);

        // Replace spaces with underscores or remove them
        $fileName = str_replace(' ', '_', $fileName); // Replace spaces with underscores
        // Alternatively, to remove spaces, use: $fileName = str_replace(' ', '', $fileName);

        // Sanitize the file name
        return preg_replace(
            '@\?.*$@', '', // Remove query parameters
            preg_replace(
                '@\.{2,}@', '', // Prevent directory traversal
                preg_replace('@[^\/\\a-zA-Z0-9\-\._]@', '', $fileName) // Allow valid characters only
            )
        );
    }
}
