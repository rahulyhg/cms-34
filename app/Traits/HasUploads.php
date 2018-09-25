<?php

namespace App\Traits;

use App\Models\Upload;
use Illuminate\Http\UploadedFile;

trait HasUploads
{
    /**
     * Get all of the model's uploads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany;
     */
    public function uploads()
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }

    /**
     * Get the public url of the first upload matching the given intent.
     *
     * @param string $intent
     *
     * @return string
     */
    public function uploadUrlByIntent(string $intent)
    {
        return optional($this->uploads->where('intent', $intent)->first())->public_path ?: '/images/placeholder.png';
    }

    /**
     * Ensures only one upload with intent ('main') exists.
     *
     * @param UploadedFile $file
     */
    public function setMainUpload(UploadedFile $file)
    {
        $this->uploads()->where('intent', 'main')->delete();

        $this->updateOrCreateUpload($file, 'main');
    }

    /**
     * Save a file and create an upload for it.
     *
     * @param UploadedFile $file
     * @param string|null  $intent
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreateUpload(UploadedFile $file, string $intent = null)
    {
        // todo: refactor model_name depends on HasAccessors
        $path = "uploads/$this->model_name/$this->id";

        $filename = $file->getClientOriginalName();

        $file->storeAs("public/$path", $filename);

        $upload = $this->uploads()->updateOrCreate([
            'path' => $path,
            'filename' => $filename,
        ], [
            'path' => $path,
            'filename' => $filename,
            'size' => $file->getSize(),
            'intent' => $intent,
        ]);

        $upload->touch();

        return $upload;
    }
}   