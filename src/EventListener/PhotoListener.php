<?php

namespace App\EventListener;

use App\Entity\Photo;

class PhotoListener
{
    public function preRemove(Photo $photo): void
    {
        $filename = $photo->getUrl();

        if (!$filename) {
            return;
        }

        $filePath = __DIR__ . '/../../public/img/' . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
