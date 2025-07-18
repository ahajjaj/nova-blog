<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {

    private $directory;

    public function __construct($targetDirectory) {
        $this->directory = $targetDirectory;
    }

    public function upload(UploadedFile $file, $sousdossier, $oldfilename = null) {

        // génération du nouveau nom de fichier
        $filename = md5(uniqid()) . '.' . $file->guessExtension();

        $target = $this->directory . $sousdossier;
        if (!is_dir($target)) {
            mkdir($target, 0777, true);
        }

        // transfert du fichier
        $file->move($target, $filename);

        if ($oldfilename && file_exists($this->directory .$sousdossier . '/' . $oldfilename)) {
            unlink($this->directory . $sousdossier . '/' . $oldfilename);
        }

        // je renvoie le nom de fichier généré
        return $filename;

    }

}