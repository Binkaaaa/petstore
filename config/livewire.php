<?php

return [
    /*
 |--------------------------------------------------------------------------
 | Temporary File Uploads
 |--------------------------------------------------------------------------
 |
 | While your users are uploading files, Livewire will create temporary
 | copies of them until you call ->store(). Those temporary files will
 | be placed in the storage/framework/livewire-tmp directory.
 |
 | You may configure which MIME types are safe to preview here.
 |
 */

'temporary_file_upload' => [
    'disk' => env('LIVEWIRE_TEMPORARY_UPLOAD_DISK', 'local'),

    'rules' => ['file', 'max:5120'], // max 1MB—even for previews

'preview_mimes' => ['png', 'jpg', 'jpeg', 'gif', 'svg', 'bmp', 'webp', 'avif'],
],
];