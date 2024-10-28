<?php
namespace BblStudio\BblStudio\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\Controller;
class VEditerController extends Controller
{
    private $veditor_views_path = "";
    public function getReplacements()
    {
        if(config('bblstudio.VEDITOR_SHOW_PHP'))
        $replacements = [
            '/@error\s*\(.*?\)/' => '<div><!--($1)beginblade--> PHP code error<!--endblade--></div>',
            '/@enderror/' => '<div><!--($1)beginblade--> PHP code enderror<!--endblade--></div>',
            '/@verbatim/' => '<div><!--($1)beginblade--> PHP code verbatim<!--endblade--></div>',
            '/@endverbatim/' => '<div><!--($1)beginblade--> PHP code endverbatim<!--endblade--></div>',
            '/@foreach\s*\(.*?\)/' => '<div><!--($1)beginblade--> PHP code foreach<!--endblade--></div>',
            '/@endforeach/' => '<div><!--($1)beginblade--> PHP code endforeach<!--endblade--></div>',
            '/@forelse\s*\(.*?\)/' => '<div><!--($1)beginblade--> PHP code forelse<!--endblade--></div>',
            '/@empty/' => '<div><!--($1)beginblade--> PHP code empty<!--endblade--></div>',
            '/@endforelse/' => '<div><!--($1)beginblade--> PHP code endforelse<!--endblade--></div>',
            '/@if\s*\(.*?\)/' => '<div><!--($1)beginblade--> PHP code if<!--endblade--></div>',
            '/@elseif\s*\(.*?\)/' => '<div><!--($1)beginblade--> PHP code elseif<!--endblade--></div>',
            '/@else/' => '<div><!--($1)beginblade-->PHP code else<!--endblade--></div>',
            '/@endif/' => '<div><!--($1)beginblade-->PHP code endif<!--endblade--></div>',
            '/@once/' => '<div><!--($1)beginblade-->PHP code once<!--endblade--></div>',
            '/@endonce/' => '<div><!--($1)beginblade-->PHP code endonce<!--endblade--></div>',
            '/@switch\s*\(.*?\)/' => '<div><!--($1)beginblade-->PHP code switch<!--endblade--></div>',
            '/@case\s*\(.*?\)/' => '<div><!--($1)beginblade-->PHP code case<!--endblade--></div>',
            '/@break/' => '<div><!--($1)beginblade-->PHP code break<!--endblade--></div>',
            '/@default/' => '<div><!--($1)beginblade-->PHP code default<!--endblade--></div>',
            '/@endswitch/' => '<div><!--($1)beginblade-->PHP code endswitch<!--endblade--></div>',
            '/@while\s*\(.*?\)/' => '<div><!--($1)beginblade-->PHP code while<!--endblade--></div>',
            '/@endwhile/' => '<div><!--($1)beginblade-->PHP code endwhile<!--endblade--></div>',
            '/@for\s*\(.*?\)/' => '<div><!--($1)beginblade-->PHP code for<!--endblade--></div>',
            '/@endfor/' => '<div><!--($1)beginblade-->PHP code endfor<!--endblade--></div>',
            '/@auth/' => '<div><!--($1)beginblade-->PHP code auth<!--endblade--></div>',
            '/@endauth/' => '<div><!--($1)beginblade-->PHP code endauth<!--endblade--></div>',
            '/@guest/' => '<div><!--($1)beginblade-->PHP code guest<!--endblade--></div>',
            '/@endguest/' => '<div><!--($1)beginblade-->PHP code endguest<!--endblade--></div>',
            '/@csrf/' => '<div><!--($1)beginblade-->PHP code csrf<!--endblade--></div>',
            '/@isset\s*\(.*?\)/' => '<div><!--($1)beginblade-->PHP code isset<!--endblade--></div>',
            '/@endisset/' => '<div><!--($1)beginblade-->PHP code endisset<!--endblade--></div>',
            '/@empty\s*\(.*?\)/' => '<div><!--($1)beginblade-->PHP code empty<!--endblade--></div>',
            '/@endempty/' => '<div><!--($1)beginblade-->PHP code endempty<!--endblade--></div>',
            '/{{\s*\$.*?\s*}}/' => '<div><!--($1)beginblade-->PHP code show<!--endblade--></div>',
             '/\{\{\s*(?!asset\()([^\}]*)\s*\}\}/' => '<!--($1)beginblade-->PHP code show<!--endblade--></div>',
            '/@php\s*\.*?\s*@endphp/' => '<div><!--($1)beginblade-->PHP code<!--endblade--></div>',
        ];
        else
        $replacements = [
            '/@error\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@enderror/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@verbatim/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endverbatim/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@foreach\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endforeach/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@forelse\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@empty/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endforelse/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@if\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@elseif\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@else/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endif/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@once/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endonce/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@switch\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@case\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@break/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@default/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endswitch/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@while\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endwhile/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@for\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endfor/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@auth/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endauth/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@guest/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endguest/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@csrf/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@isset\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endisset/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@empty\s*\(.*?\)/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@endempty/' => '<!--($1)beginblade--> <!--endblade-->',
            '/{{\s*\$.*?\s*}}/' => '<!--($1)beginblade--> <!--endblade-->',
            '/\{\{\s*(?!asset\()([^\}]*)\s*\}\}/' => '<!--($1)beginblade--> <!--endblade-->',
            '/@php\s*\.*?\s*@endphp/' => '<!--($1)beginblade--> <!--endblade-->',
        ];
        return $replacements;
    }
    public function getWrapPatterns()
    {
        // Patterns for directives to wrap with comments
        $wrapPatterns = [

            '//\{\{\s*asset\((.*?)\)\s*\}\}/' => '<div><!--($2)beginblade-->{{asset($1)}}<!--endblade--></div>', // Keep as is for capture
            '/@lang\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@lang($1)<!--endblade--></div>', // Keep as is for capture
            '/@vite\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@vite($1)<!--endblade--></div>', // Keep as is for capture
            '/@push\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@push($1)<!--endblade--></div>', // Keep as is for capture
            '/@endpush/' => '<div><!--($2)beginblade-->@endpush<!--endblade--></div>', // @endsection
            '/@section\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@section($1)<!--endblade--></div>', // Keep as is for capture
            '/@endsection/' => '<div><!--($2)beginblade-->@endsection<!--endblade--></div>', // @endsection
            '/@yield\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@yield($1)<!--endblade--></div>', // Keep as is for capture
            '/@include\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@include($1)<!--endblade--></div>', // Keep as is for capture
            '/@extends\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@extends($1)<!--endblade--></div>', // Keep as is for capture
            '/@method\s*\((.*?)\)/' => '<div><!--($2)beginblade-->@method($1)<!--endblade--></div>', // Keep as is for capture
            '/<x-(.*?)>/s' => '<div><!--($2)beginblade--><x-$1><!--endblade--></div>', // Capture arguments for opening tags
            '/<\/x-(.*?)>/s' => '<div><!--($2)beginblade--></x-$1><!--endblade--></div>', // Capture arguments for closing tags
        ];
        return $wrapPatterns;
    }
    public function index()
    {
        $this->veditor_views_path = config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH');
        $path = resource_path('views/' . $this->veditor_views_path);
        $fileStructure = $this->getFileStructure($path);
       // return $fileStructure;
        return view('vendor.bblstudio.editor', compact('fileStructure'));
    }
    public function openPageInVEditor($page)
    {
        if (config('bblstudio.VEDITOR') == 'AUTO')
            return $this->openPageInVEditorAuto($page);
        elseif (config('bblstudio.VEDITOR') == 'CONFIG')
            return  $this->openPageInVEditorConfig($page);
        else
            return dd('.env VEDITOR= CONFIG or AUTO not Found');
    }
    public function openPageInVEditorAuto($page)
    {
        $this->veditor_views_path = config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH');
        $path = resource_path('views/' . $this->veditor_views_path);
        $structure = $this->getFileStructure($path);
        $filePath = config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH') . $this->getFilePathByName($structure, $page);
        if ($filePath == null) {
            return  "$page not found in the structure.";
        }
        $html = $this->processBladeFileWithDirectivesAuto($filePath);
        return  Blade::render($html);
    }
    public function openPageInVEditorConfig($page)
    {
        // Get the class and method names from the environment
        $controllerClass = "App\Http\Controllers\\" . config('bblstudio.VEDITOR_GET_CONTENT_BY_NAME_CONTROLLER_NAME');
        $methodName = config('bblstudio.VEDITOR_GET_CONTENT_BY_NAME_METHOD_NAME');
        if (!$controllerClass)
            return dd('.env VEDITOR_GET_CONTENT_BY_NAME_CONTROLLER_NAME=!!!');
        if (!$methodName)
            return dd('.env VEDITOR_GET_CONTENT_BY_NAME_METHOD_NAME=!!!');
        // Redirect with restored content
        $controller = new $controllerClass();
        // Call the method dynamically
        $content = call_user_func([$controller, $methodName], $page);
        if ($content == null) {
            return  "$page not found in the structure.";
        }
        $html = $this->processBladeFileWithDirectivesConfig($content);
        return  Blade::render($html);
    }
    public function getFileStructure($path)
    {
        if (config('bblstudio.VEDITOR') == 'AUTO')
            return $this->getFileStructureAuto($path);
        elseif (config('bblstudio.VEDITOR') == 'CONFIG')
            return $this->getFileStructureConfig();
        else
            return dd('.env VEDITOR= CONFIG or AUTO not Found');
    }
    public function getFileStructureAuto($path)
    {
        $structure = [];
        if (File::exists($path)) {
            $directories = File::directories($path);
            // Do something with the directories
        } else {
            // Handle the case where the path does not exist
            return dd( "The specified path does not exist. env VEDITOR_FOLDER_VIEWS_PATH = ".config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH')."  !!!");
        }
        foreach ($directories as $directory) {
            $structure = array_merge($structure, $this->getFileStructure($directory));
        }
        $files = File::files($path);
        foreach ($files as $file) {
            if (in_array($file->getExtension(), ['php', 'html'])) {
                // Extracting filename and folder information
                $filenameWithoutExt = str_replace('.blade', '', $file->getFilenameWithoutExtension());
                if($filenameWithoutExt!='editor'){
                $folderName = basename($path);
                if(config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH'))
                $relativePath = str_replace(base_path() . '/resources/views/' . config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH'), '', $file->getPath());
           else
               $relativePath = str_replace(base_path() . '/resources/views' . config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH'), '', $file->getPath());

                // Constructing the folder-subfolder-page format for the URL
                $pathParts = array_filter(explode('/', $relativePath)); // Remove empty segments
                $pathParts[] = $filenameWithoutExt; // Add the file name to the path parts
                $urlStructure = '/' . config('bblstudio.VEDITOR_URL') . '/' . implode('_', $pathParts); // Join with hyphens
                $Structurename = implode('-', $pathParts);
                // Constructing the folder/sub-folder/page name for the file path

                $folderStructure = $relativePath . '/' . $file->getFilename();
                $structure[strtolower($Structurename)] = [
                    'name' => strtolower($Structurename),
                    'filename' => $file->getFilename(),
                    'file' => $folderStructure,
                    'url' => strtolower($urlStructure),
                    'title' => ucfirst(str_replace(['-', '_'], ' ', $filenameWithoutExt)),
                    'folder' => $folderName,
                    'description' => ''
                ];
                }
            }
        }
        return $structure;
    }
    public function getFileStructureConfig()
    {
        // Get the class and method names from the environment
        $controllerClass = "App\Http\Controllers\\" . config('bblstudio.VEDITOR_LIST_STRUCTER_CONTROLLER_NAME');
        $methodName = config('bblstudio.VEDITOR_LIST_STRUCTER_METHOD_NAME');
        if (!$controllerClass)
            return dd('.env VEDITOR_LIST_STRUCTER_CONTROLLER_NAME=!!!');
        if (!$methodName)
            return dd('.env VEDITOR_LIST_STRUCTER_METHOD_NAME=!!!');
        // Redirect with restored content
        $controller = new $controllerClass();
        // Call the method dynamically
        $input = call_user_func([$controller, $methodName]);
        $structure = [];
        foreach ($input as $key => $value) {
            $structure[$value['fileName']] = [
                'name' => $value['fileName'],
                'filename' => $value['fileName'],
                'file' => $value['fileName'],
                'url' => '/' . config('bblstudio.VEDITOR_URL') . '/' . $value['fileName'],
                'title' => $value['fileName'],
                'folder' => $value['folderName'],
                'description' => ''
            ];
        }
        return $structure;
    }
    public function getFilePathWithOutExtensionByName($structure, $name)
    {
        $name = str_replace('_', '-', $name);
        if (isset($structure[$name])) {
            // Get the file path, remove the .blade.php extension, and replace slashes with dots
            return str_replace(['.blade.php', '/'], ['', '.'], $structure[$name]['file']);
        }
        return null; // Return null if the name is not found
    }
    public function getFilePathByName($structure, $name)
    {
        $name = str_replace('_', '-', $name);
        if (isset($structure[$name])) {
            // Get the file path, remove the .blade.php extension, and replace slashes with dots
            return  $structure[$name]['file'];
        }
        return null; // Return null if the name is not found
    }
    public function processBladeFileWithDirectivesAuto($bladeFilePath)
    {
        // Use the correct path for the Blade file in the resources/views directory
        $filePath = resource_path('views/' . $bladeFilePath);
        // Check if the file exists before attempting to read it
        if (!file_exists($filePath)) {
            return "File does not exist: " . $filePath;
        }
        // Read the content of the Blade file
        $content = file_get_contents($filePath);
        // Define the patterns and their replacements for directives to replace
        $replacements = $this->getReplacements();
        // Patterns for directives to wrap with comments
        $wrapPatterns = $this->getWrapPatterns();
        $index = 0;
        // Replace all directives except those we want to wrap with comments
        foreach ($replacements as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$index, $replacement) {
                // Replace with the modified code and increment the index
                $replacementWithIndex = str_replace('$1', $index++, $replacement);
                return $replacementWithIndex;
            }, $content);
        }
        // Wrap specific directives with comments and store them
        foreach ($wrapPatterns as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$index, $replacement) {
                // Check if the first capture group exists
                if (isset($matches[1])) {
                    // Replace with the wrapped code using the matched group correctly and increment the index
                    $replacementWithIndex = str_replace(['$1', '$2'], [$matches[1], $index++], $replacement);
                    return $replacementWithIndex;
                }
                // If no capture group is found, return the replacement with the incremented index as is
                return str_replace('$2', $index++, $replacement);
            }, $content);
        }
        return $content;
    }
    public function processBladeFileWithDirectivesConfig($content)
    {
        // Define the patterns and their replacements for directives to replace
        $replacements = $this->getReplacements();
        // Patterns for directives to wrap with comments
        $wrapPatterns =  $this->getWrapPatterns();
        $index = 0;
        // Replace all directives except those we want to wrap with comments
        foreach ($replacements as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$index, $replacement) {
                // Replace with the modified code and increment the index
                $replacementWithIndex = str_replace('$1', $index++, $replacement);
                return $replacementWithIndex;
            }, $content);
        }
        // Wrap specific directives with comments and store them
        foreach ($wrapPatterns as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$index, $replacement) {
                // Check if the first capture group exists
                if (isset($matches[1])) {
                    // Replace with the wrapped code using the matched group correctly and increment the index
                    $replacementWithIndex = str_replace(['$1', '$2'], [$matches[1], $index++], $replacement);
                    return $replacementWithIndex;
                }
                // If no capture group is found, return the replacement with the incremented index as is
                return str_replace('$2', $index++, $replacement);
            }, $content);
        }
        return $content;
    }
    public function processBladeFileWithDirectivesJsonAuto($filePath)
    {
        if (!file_exists($filePath)) {
            return "File does not exist: " . $filePath;
        }
        // Read the content of the Blade file
        $content = file_get_contents($filePath);
        // Define the patterns and their replacements for directives to replace
        $replacements = $this->getReplacements();
        // Patterns for directives to wrap with comments
        $wrapPatterns =  $this->getWrapPatterns();
        // Array to store the replaced/wrapped Blade code
        $bladeCodeArray = [];
        // Replace all directives except those we want to wrap with comments
        foreach ($replacements as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$bladeCodeArray, $replacement) {
                // Store the original Blade code in the array
                $bladeCodeArray[] = $matches[0];
                // Replace with the modified code
                return $replacement;
            }, $content);
        }
        // Wrap specific directives with comments and store them
        foreach ($wrapPatterns as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$bladeCodeArray, $replacement) {
                // Store the original Blade code in the array
                $bladeCodeArray[] = $matches[0];
                // Check if the first capture group exists
                if (isset($matches[1])) {
                    // Replace with the wrapped code using the matched group correctly
                    return str_replace('$1', $matches[1], $replacement);
                }
                // If no capture group is found, return the replacement as is
                return $replacement;
            }, $content);
        }
        return $bladeCodeArray;
    }
    public function processBladeFileWithDirectivesJsonConfig($fileName)
    {
        if (!$fileName) {
            return dd("File does not exist: " . $fileName);
        }
        // Get the class and method names from the environment
        $controllerClass = "App\Http\Controllers\\" . config('bblstudio.VEDITOR_GET_CONTENT_BY_NAME_CONTROLLER_NAME');
        $methodName = config('bblstudio.VEDITOR_GET_CONTENT_BY_NAME_METHOD_NAME');
        if (!$controllerClass)
            return dd('.env VEDITOR_GET_CONTENT_BY_NAME_CONTROLLER_NAME=!!!');
        if (!$methodName)
            return dd('.env VEDITOR_GET_CONTENT_BY_NAME_METHOD_NAME=!!!');
        // Redirect with restored content
        $controller = new $controllerClass();
        // Call the method dynamically
        $content = call_user_func([$controller, $methodName], $fileName);
        // Define the patterns and their replacements for directives to replace
        $replacements = $this->getReplacements();
        // Patterns for directives to wrap with comments
        $wrapPatterns =  $this->getWrapPatterns();
        // Array to store the replaced/wrapped Blade code
        $bladeCodeArray = [];
        // Replace all directives except those we want to wrap with comments
        foreach ($replacements as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$bladeCodeArray, $replacement) {
                // Store the original Blade code in the array
                $bladeCodeArray[] = $matches[0];
                // Replace with the modified code
                return $replacement;
            }, $content);
        }
        // Wrap specific directives with comments and store them
        foreach ($wrapPatterns as $pattern => $replacement) {
            $content = preg_replace_callback($pattern, function ($matches) use (&$bladeCodeArray, $replacement) {
                // Store the original Blade code in the array
                $bladeCodeArray[] = $matches[0];
                // Check if the first capture group exists
                if (isset($matches[1])) {
                    // Replace with the wrapped code using the matched group correctly
                    return str_replace('$1', $matches[1], $replacement);
                }
                // If no capture group is found, return the replacement as is
                return $replacement;
            }, $content);
        }
        return $bladeCodeArray;
    }
    public function restoreBladeFileOrigin($file, $html)
    {
        // Read the modified Blade file
        if (!file_exists($file)) {
            return "Modified Blade file does not exist: " . $file;
        }
        // Read the JSON file to get the Blade code array
        $bladeCodeArray = $this->processBladeFileWithDirectivesJsonAuto($file);
        // Prepare the content to restore
        $modifiedContent = $html;
        // Restore the original Blade code from the array
        foreach ($bladeCodeArray as $index => $originalCode) {
            // Use patterns that match both <p> and <div> placeholders
            $patterns = [
                '/<div><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<div class=""><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<!--\(' . $index . '\)beginblade-->.*?<!--endblade-->/s'
            ];
            // Replace each pattern with the original Blade code
            foreach ($patterns as $pattern) {
                $modifiedContent = preg_replace($pattern, $originalCode, $modifiedContent, 1);
            }
        }
        // Write the restored content back to the modified Blade file
        file_put_contents($file, $modifiedContent);
        return "Blade file restored successfully.";
    }
    public function restoreBladeFileCopy($file, $html)
    {
        if (!file_exists($file)) {
            return "Modified Blade file does not exist: " . $file;
        }
        // Read the JSON file
        $bladeCodeArray = $this->processBladeFileWithDirectivesJsonAuto($file);
        // Read the modified Blade file
        // Prepare the content to restore
        $modifiedContent = $html;
        // Restore the original Blade code from the array
        foreach ($bladeCodeArray as $index => $originalCode) {
            // Use patterns that match both <p> and <div> placeholders
            $patterns = [
                '/<div><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<div class=""><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<!--\(' . $index . '\)beginblade-->.*?<!--endblade-->/s'
            ];
            // Replace each pattern with the original Blade code
            foreach ($patterns as $pattern) {
                $modifiedContent = preg_replace($pattern, $originalCode, $modifiedContent, 1);
            }
        }
        // Save the modified Blade file
        $modifiedBladeFilePath = $file . '.copy';
        // Ensure the directory exists before trying to write the file
        $modifiedDirectory = dirname($modifiedBladeFilePath);
        if (!file_exists($modifiedDirectory)) {
            mkdir($modifiedDirectory, 0777, true);
        }
        // Write the restored content back to the modified Blade file
        file_put_contents($modifiedBladeFilePath, $modifiedContent);
        return "Blade file restored successfully.";
    }
    public function restoreBladeFileFunAuto($file, $html)
    {
        // Check if the modified Blade file exists
        if (!file_exists($file)) {
            return "Modified Blade file does not exist: " . $file;
        }
        // Read the original Blade code from the JSON file
        $bladeCodeArray = $this->processBladeFileWithDirectivesJsonAuto($file);
        $modifiedContent = $html;
        // Restore the original Blade code from the array
        foreach ($bladeCodeArray as $index => $originalCode) {
            $patterns = [
                '/<div><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<div class=""><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<!--\(' . $index . '\)beginblade-->.*?<!--endblade-->/s'
            ];
            // Replace each pattern with the original Blade code
            foreach ($patterns as $pattern) {
                $modifiedContent = preg_replace($pattern, $originalCode, $modifiedContent, 1);
            }
        }
        // Get the class and method names from the environment
        $controllerClass = "App\Http\Controllers\\" . config('bblstudio.VEDITOR_SAVE_DATA_FUN_CONTROLLER_NAME');
        $methodName = config('bblstudio.VEDITOR_SAVE_DATA_FUN_METHOD_NAME');
        if (!$controllerClass)
            return dd('.env VEDITOR_SAVE_DATA_FUN_CONTROLLER_NAME=!!!');
        if (!$methodName)
            return dd('.env VEDITOR_SAVE_DATA_FUN_METHOD_NAME=!!!');
        // Redirect with restored content
        $controller = new $controllerClass();
        // Call the method dynamically
        return call_user_func([$controller, $methodName], $file, $modifiedContent);
    }
    public function restoreBladeFileFunConfig($file, $html)
    {
        // Check if the modified Blade file exists
        if (!$file) {
            return "Modified Blade file does not exist: " . $file;
        }
        // Read the original Blade code from the JSON file
        $bladeCodeArray = $this->processBladeFileWithDirectivesJsonConfig($file);
        $modifiedContent = $html;
        // Restore the original Blade code from the array
        foreach ($bladeCodeArray as $index => $originalCode) {
            // Use patterns that match both <p> and <div> placeholders
            $patterns = [
                '/<div><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<div class=""><!--\(' . $index . '\)beginblade-->.*?<!--endblade--><\/div>/s',
                '/<!--\(' . $index . '\)beginblade-->.*?<!--endblade-->/s'
            ];
            // Replace each pattern with the original Blade code
            foreach ($patterns as $pattern) {
                $modifiedContent = preg_replace($pattern, $originalCode, $modifiedContent, 1);
            }
        }
        // Get the class and method names from the environment
        $controllerClass = "App\Http\Controllers\\" . config('bblstudio.VEDITOR_SAVE_DATA_FUN_CONTROLLER_NAME');
        $methodName = config('bblstudio.VEDITOR_SAVE_DATA_FUN_METHOD_NAME');
        if (!$controllerClass)
            return dd('.env VEDITOR_SAVE_DATA_FUN_CONTROLLER_NAME=!!!');
        if (!$methodName)
            return dd('.env VEDITOR_SAVE_DATA_FUN_METHOD_NAME=!!!');
        // Redirect with restored content
        $controller = new $controllerClass();
        // Call the method dynamically
        return call_user_func([$controller, $methodName], $file, $modifiedContent);
    }
    public function savePage(Request $request)
    {
        $file = $request->input('file');
        $html = $request->input('html');
        if (config('bblstudio.VEDITOR') == 'AUTO')
            return $this->savePageAuto($file, $html);
        elseif (config('bblstudio.VEDITOR') == 'CONFIG')
            return $this->savePageConfig($file, $html);
        else
            return dd('.env VEDITOR= CONFIG or AUTO not Found');
    }
    public function savePageAuto($file, $html)
    {
        $filePath = resource_path('views/' . config('bblstudio.VEDITOR_FOLDER_VIEWS_PATH') . $file);
        switch (config('bblstudio.VEDITOR_SAVE')) {
            case 'origin':
                $this->restoreBladeFileOrigin($filePath, $html);
                break;
            case 'copy':
                $this->restoreBladeFileCopy($filePath, $html);
                break;
            case 'fun':
                $this->restoreBladeFileFunAuto($filePath, $html);
                break;
            default:
                return dd('.env VEDITOR_SAVE=!!! support fun/copy/origin');
                break;
        }
    }
    public function savePageConfig($file, $html)
    {
        switch (config('bblstudio.VEDITOR_SAVE')) {
            case 'fun':
                $this->restoreBladeFileFunConfig($file, $html);
                break;
            case 'copy':
                return dd('.env VEDITOR=CONFIG Not Support copy Save');
                break;
            case 'origin':
                return dd('.env VEDITOR=CONFIG Not Support origin Save');
                break;
            default:
                return dd('.env VEDITOR_SAVE=!!! support fun');
                break;
        }
    }
}
