<?php

namespace App\Services;

use App\Models\Media\MediaFile;
use App\Models\Core\ActivityLog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MediaUploadService
{
    // Ekstensi berbahaya yang tidak boleh dieksekusi server
    protected array $forbiddenExtensions = ['php', 'exe', 'sh', 'bat', 'cmd', 'js', 'pl', 'py', 'cgi'];

    /**
     * Upload File Aman & Tulis Metadata ke Database
     */
    public function upload(
        UploadedFile $file,
        int $uploaderUserId,
        string $folder = 'uploads',
        string $visibility = 'MEMBER',
        string $disk = 'public'
    ): MediaFile {
        $extension = strtolower($file->getClientOriginalExtension());

        // Security Check: Tolak file eksekusi server
        if (in_array($extension, $this->forbiddenExtensions)) {
            ActivityLog::create([
                'actor_user_id' => $uploaderUserId,
                'action' => 'media.upload',
                'resource_type' => 'media_file',
                'result' => 'FORBIDDEN',
                'before' => ['attempted_file' => $file->getClientOriginalName()],
            ]);

            throw new \InvalidArgumentException('Tipe file eksekusi tidak diizinkan untuk diunggah.');
        }

        $originalName = $file->getClientOriginalName();
        $storedName = Str::uuid() . '.' . $extension;
        $path = $file->storeAs($folder, $storedName, $disk);

        $mediaFile = MediaFile::create([
            'original_name' => $originalName,
            'stored_name' => $storedName,
            'mime_type' => $file->getClientMimeType(),
            'extension' => $extension,
            'size' => $file->getSize(),
            'storage_disk' => $disk,
            'storage_path' => $path,
            'visibility' => $visibility,
            'status' => 'ACTIVE',
            'uploaded_by' => $uploaderUserId,
        ]);

        // Audit Log
        ActivityLog::create([
            'actor_user_id' => $uploaderUserId,
            'action' => 'media.upload',
            'resource_type' => 'media_file',
            'resource_id' => $mediaFile->id,
            'result' => 'SUCCESS',
        ]);

        return $mediaFile;
    }
}