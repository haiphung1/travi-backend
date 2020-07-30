<?php

namespace App\Services;

class UploadService
{
    public function upload($data)
    {
        $filename = $data->image->getClientOriginalName();
        $filename = str_replace(' ', '-', $filename);
        $filename = uniqid() . '-' . $filename;

        $path = $data->image->move('images', $filename);

        return $path;
    }
}
