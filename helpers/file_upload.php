<?php
class FileUpload {
    private $publicBase = 'uploads/';
    private $basePath = __DIR__ . '/../uploads/';
    private $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private $maxSize = 500 * 1024 * 1024; // 500MB

    public function __construct() {
        $this->createDirectories();
    }

    private function createDirectories() {
        $directories = ['images', 'education', 'projects', 'businesses'];
        foreach ($directories as $dir) {
            $path = $this->basePath . $dir;
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }
    }

    // Profile image upload
    public function uploadProfileImage($file) {
        return $this->uploadFile($file, 'images/');
    }

    // Education image upload
    public function uploadEducationImage($file) {
        return $this->uploadFile($file, 'education/');
    }

    // Project image upload
    public function uploadProjectImage($file) {
        return $this->uploadFile($file, 'projects/');
    }

    // Business logo upload
    public function uploadBusinessLogo($file) {
        return $this->uploadFile($file, 'businesses/');
    }

    // General file upload method
    private function uploadFile($file, $subdir) {
        $response = [
            'success' => false,
            'message' => '',
            'file_path' => '',
            'file_name' => ''
        ];

        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $response['message'] = $this->getUploadError($file['error']);
            error_log("File upload error: " . $response['message']);
            return $response;
        }

        // Check file size
        if ($file['size'] > $this->maxSize) {
            $response['message'] = 'File too large. Maximum size is 500MB.';
            error_log("File too large: " . $file['size']);
            return $response;
        }

        // Check file type
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedTypes)) {
            $response['message'] = 'Invalid file type. Allowed: ' . implode(', ', $this->allowedTypes);
            error_log("Invalid file type: " . $extension);
            return $response;
        }

        // Generate unique filename
        $filename = $subdir . uniqid() . '_' . time() . '.' . $extension;
        $fullPath = $this->basePath . $filename;
        $publicPath = $this->publicBase . $filename;

        error_log("Attempting to move file from: " . $file['tmp_name'] . " to: " . $fullPath);

        // Check if source file exists
        if (!file_exists($file['tmp_name'])) {
            $response['message'] = 'Temporary file not found.';
            error_log("Source file doesn't exist: " . $file['tmp_name']);
            return $response;
        }

        // Check if destination directory is writable
        $dirPath = dirname($fullPath);
        if (!is_writable($dirPath)) {
            $response['message'] = 'Server error: Cannot save file. Directory not writable.';
            error_log("Destination directory not writable: " . $dirPath);
            return $response;
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            error_log("File moved successfully to: " . $fullPath);
            
            // Verify the file was actually created
            if (file_exists($fullPath)) {
                $response['success'] = true;
                $response['file_path'] = $publicPath;
                $response['file_name'] = $filename;
                $response['message'] = 'File uploaded successfully!';
            } else {
                $response['message'] = 'File upload failed. Please try again.';
                error_log("File move reported success but file doesn't exist at destination: " . $fullPath);
            }
        } else {
            $response['message'] = 'Failed to upload file. Please try again.';
            error_log("move_uploaded_file failed");
            $last_error = error_get_last();
            error_log("Last error: " . print_r($last_error, true));
        }

        return $response;
    }

    private function getUploadError($errorCode) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize directive.',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE directive.',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'PHP extension stopped the file upload.'
        ];

        return $errors[$errorCode] ?? 'Unknown upload error.';
    }

    public function deleteFile($filePath) {
        // Accept either public path (uploads/...) or absolute filesystem path
        if (strpos($filePath, $this->publicBase) === 0) {
            $fsPath = $this->basePath . substr($filePath, strlen($this->publicBase));
        } else {
            $fsPath = $filePath;
        }

        if (file_exists($fsPath)) {
            return unlink($fsPath);
        }
        return false;
    }

    // Helper method to get file type
    public function getFileType($filename) {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($extension, $this->allowedTypes)) {
            return 'image';
        } else {
            return 'document';
        }
    }

    // Helper method to format file size
    public function formatFileSize($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
?>