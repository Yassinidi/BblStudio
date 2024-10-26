# BBL Studio Configuration
# ========================
# VEDITOR mode options:
# - AUTO: Automatic configuration.
# - CONFIG: Manual configuration.
# - AUTO + CONFIG: Automatic with additional configurations.

VEDITOR="AUTO"  # Options: AUTO / CONFIG / AUTO + CONFIG. Required for AUTO mode.

# Path Configuration
# ------------------
VEDITOR_FOLDER_VIEWS_PATH="user_page/auth"  # Required for AUTO mode. Path to the folder where views are stored.

# URL and Routing
# ---------------
VEDITOR_URL="bblstudio"  # Required for AUTO + CONFIG. The base URL for accessing the VEDITOR.
VEDITOR_ROUTE_NAME="bblstudio"  # Required for AUTO + CONFIG. The route name used in the URL.

# Save Configuration
# ------------------
# Options: origin / copy / fun
# - origin: Save directly to the original file.
# - copy: Save a copy of the file.
# - fun: Use a custom function to save.
VEDITOR_SAVE="origin"  # Required for AUTO {origin / copy / fun} + CONFIG {fun}.

# Custom Save Function Configuration
# ----------------------------------
# Required if VEDITOR_SAVE is set to "fun".
VEDITOR_SAVE_DATA_FUN_CONTROLLER_NAME=""  # Controller name for the custom save function.
VEDITOR_SAVE_DATA_FUN_METHOD_NAME=""  # Method name for the custom save function.
# The function signature should be: fun($filePath or $fileName, $newContent).

# Content Retrieval Configuration
# -------------------------------
# Required for CONFIG mode.
VEDITOR_GET_CONTENT_BY_NAME_CONTROLLER_NAME=""  # Controller name for retrieving content by name.
VEDITOR_GET_CONTENT_BY_NAME_METHOD_NAME=""  # Method name for retrieving content by name.
# The function signature should be: fun($fileName).

# Structure Listing Configuration
# -------------------------------
# Required for CONFIG mode.
VEDITOR_LIST_STRUCTER_CONTROLLER_NAME=""  # Controller name for listing the structure.
VEDITOR_LIST_STRUCTER_METHOD_NAME=""  # Method name for listing the structure.
# The structure format should be: [[fileName => string (unique), folderName => string], [...]].

# Additional Configuration
# ------------------------
VEDITOR_SHOW_PHP=true  # Enable or disable PHP code display in the editor.
VEDITOR_MIDDLEWARE_ALIAS=""  # Middleware alias used for routing if needed.

