<?php

namespace App\Ship\Captain\Foundation\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RenameUploadedFiles
{
    public function handle(Request $request, Closure $next): mixed
    {
        $fileBag = $request->files;
        foreach ($request->files as $key => $input) {
            if (is_a($input, UploadedFile::class)) {
                $fileBag->set($key, $this->rename($input));
            } else {
                foreach ($input as &$files) {
                    foreach ($files as $counter => $file) {
                        $files[$counter] = $this->rename($file);
                    }
                }
                $fileBag->set($key, $input);
            }
        }

        return $next($request);
    }

    protected function rename(UploadedFile $file): UploadedFile
    {
        $fileParts = (object) pathinfo('.' . $file->getClientOriginalName());
        $newFileName = Str::slug($fileParts->filename) . '.' . $file->getClientOriginalExtension();

        return new UploadedFile($file->getPathname(), $newFileName);
    }
}
