<?php

namespace App\Support;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class Uploader
{
    /**
     * Construct upload directory path.
     *
     * @param  string  $directory
     *
     * @return string
     */
    public static function dirPath(string $directory)
    {
        $today = Date::today();

        return implode(DIRECTORY_SEPARATOR, [$directory, $today->year, $today->month]);
    }

    /**
     * Generate random file name.
     * Framework does this already, but this method give more control on basename and extension.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     *
     * @return string
     */
    public static function generateName($file)
    {
        $baseName = Str::random(40);

        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $extension = $file->guessClientExtension();
        } else {
            $extension = \Illuminate\Support\Facades\File::extension($file);
        }

        return $baseName.'.'.$extension;
    }
}
