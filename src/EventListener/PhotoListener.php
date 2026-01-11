<?php

namespace App\EventListener;

use App\Entity\Photo;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class PhotoListener
{
    public function preRemove(Photo $photo, LifecycleEventArgs $args): void
    {
        $filename = $photo->getUrl();

        if (!$filename) {
            return;
        }

        $filePath = __DIR__ . '/../../public/' . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
