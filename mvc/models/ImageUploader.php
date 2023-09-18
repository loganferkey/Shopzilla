<?php

class ImageUploader {
    public $file, $name, $extension, $fullname, $size;
    public function __construct($file) {
        $this->file = $file;
        $this->name = pathinfo($this->file['name'], PATHINFO_FILENAME);
        $this->extension = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        $this->fullname = $this->file['name'];
        $this->size = $this->file['size'];
        return $this;
    }
    /**
     * Moves a file into the specified directory with specific parameters
     * @param string $dir The directory the file needs to be moved into
     * @param int $maxFileSize The max file size in MB i.e 1, 2, 3, 24, etc.
     * @param string $allowedFileExtensions File extensions allowed, returns false on wrong file type, i.e "jpg,png,jpeg,gif"
     * @param ?mixed $renameFile NULLABLE, supply the new file name you want it to be renamed to
     */
    public function moveFile($dir, $allowedFileExtensions, $renameFile = null) {
        // Necessary checking to make sure file is compatible
        $filename = $renameFile == null ? $this->fullname : $renameFile.'.'.$this->extension;
        if ($this->file['error'] != UPLOAD_ERR_OK) { return false; }
        if (!in_array($this->extension, explode(",", $allowedFileExtensions))) { return false; }
        if (file_exists($dir.$filename)) {
            // Remove the already existing file if it exists
            unlink($dir.$filename);
        }
        if (!move_uploaded_file($this->file['tmp_name'], $dir.$filename)) {
            // File failed to upload
            return false;
        }
        // Everything worked!
        return true;    
    }
}