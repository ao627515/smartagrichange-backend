<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaService
{
    /**
     * Upload un ou plusieurs fichiers pour un modèle donné, dans une collection donnée.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $collectionName
     * @param  UploadedFile[]|\Illuminate\Http\UploadedFile|null  $files
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media[]|\Spatie\MediaLibrary\MediaCollections\Models\Media|null
     */
    public function uploadFiles($model, string $collectionName, $files)
    {
        if (is_null($files)) {
            return null;
        }

        $medias = [];

        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $medias[] = $model->addMedia($file)
                ->toMediaCollection($collectionName);
        }

        return count($medias) === 1 ? $medias[0] : $medias;
    }
}
