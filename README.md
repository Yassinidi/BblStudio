<!DOCTYPE html>
<body>

<h1>BBL Studio </h1>
<img src="https://github.com/Yassinidi/BblStudio/blob/eeaaf6e6383cc3716fc5c3e1c631ccb920959a43/public/BblStudio/img/Design%20sans%20titre.png?raw=true" />
<h2>Description</h2>
<pre>
BBL Studio is a powerful tool for managing and editing your application views. 
This configuration file sets up the VEDITOR mode and various options for 
customizing how the editor operates within your Laravel application.
</pre>
<h2>Requirements</h2>
<pre>
- Laravel: Minimum version 8
- PHP: Minimum version 8
</pre> 

<h2>Installation</h2>
<pre>
1. Run the following command to install BBL Studio:
   composer require bblstudio/bblstudio
   
2. Publish the package assets(if not run auto!):
   php artisan vendor:publish --tag=laravel-assets --ansi --force
   
3. Publish the package views:
   php artisan vendor:publish --tag=laravel-views --ansi --force
   
4. Publish the package config:
   php artisan vendor:publish --tag=config --ansi --force
   
</pre>
<h2>For using Bootstrap components</h2>
<pre>
add this imoprt in page Edit :
   <link href="/vendor/BblStudio/css/editor.css" rel="stylesheet">      
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="/vendor/BblStudio/js/popper.min.js"></script>
    <script src="/vendor/BblStudio/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/holderjs@2.9.4/holder.js"></script>
</pre>
<h1>BBL Studio Configuration .env file</h1>
<h2>Mode Options</h2>
<pre>
# - AUTO: Automatic configuration.
# - CONFIG: Manual configuration.
# - AUTO + CONFIG: Automatic with additional configurations.
VEDITOR = "AUTO"  # Required for AUTO mode.
</pre>

<h2>Path Configuration</h2>
<pre>
VEDITOR_FOLDER_VIEWS_PATH = "user_page/auth"  # Required for AUTO mode or Default =Views.
</pre>

<h2>URL and Routing</h2>
<pre>
VEDITOR_URL = "bblstudio"  # Required for AUTO + CONFIG.
VEDITOR_ROUTE_NAME = "bblstudio"  # Required for AUTO + CONFIG.
</pre>

<h2>Save Configuration</h2>
<pre>
# Options: origin / copy / fun
# - origin: Save directly to the original file.
# - copy: Save a copy of the file.
# - fun: Use a custom function to save.
VEDITOR_SAVE = "origin"  # Required for AUTO {origin / copy / fun} + CONFIG {fun}.
</pre>

<h2>Custom Save Function Configuration</h2>
<pre>
# Required if VEDITOR_SAVE is set to "fun".
VEDITOR_SAVE_DATA_FUN_CONTROLLER_NAME = ""  # Controller name for the custom save function.
VEDITOR_SAVE_DATA_FUN_METHOD_NAME = ""  # Method name for the custom save function.
# The function signature should be: fun($filePath or $fileName, $newContent).
</pre>

<h2>Content Retrieval Configuration</h2>
<pre>
# Required for CONFIG mode.
VEDITOR_GET_CONTENT_BY_NAME_CONTROLLER_NAME = ""  # Controller name for retrieving content by name.
VEDITOR_GET_CONTENT_BY_NAME_METHOD_NAME = ""  # Method name for retrieving content by name.
# The function signature should be: fun($fileName).
</pre>

<h2>Structure Listing Configuration</h2>
<pre>
# Required for CONFIG mode.
VEDITOR_LIST_STRUCTER_CONTROLLER_NAME = ""  # Controller name for listing the structure.
VEDITOR_LIST_STRUCTER_METHOD_NAME = ""  # Method name for listing the structure.
# The structure format should be: [[fileName => string (unique), folderName => string], [...]].
</pre>

<h2>Additional Configuration</h2>
<pre>
VEDITOR_SHOW_PHP = true  # Enable or disable PHP code display in the editor.
VEDITOR_MIDDLEWARE_ALIAS = ""  # Middleware alias used for routing if needed.
</pre>

</body>
</html>
