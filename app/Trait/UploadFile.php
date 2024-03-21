<?php

namespace App\Trait;

use App\Models\Image;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    /**
     * $diskImageable
     *
     * @var string
     */
    protected $diskImageable = 'public';

    /**
     * $basePathImageable
     *
     * @var string
     */
    // protected $basePathImageable = '';

    /**
     * $relatiunshipImageable
     *
     * @var string
     */
    // protected $relatiunshipImageable = 'imageable';

    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $file
     * @return Image
     */
    public function upload(
        UploadedFile $file,
        string $path,
        ?string $description = null,
        string $name = ''):Image
    {
        try{
            if(!$name){
                $name = uuid_create();
            }
            $path = $this->basePathImageable . '/' . $path;
            $fullPath = $path . '/' . $name . '.'.$file->getClientOriginalExtension();
            $file->storeAs(
                $path,
                $name. '.'.$file->getClientOriginalExtension(),
                $this->diskImageable
            );
            $relation = $this->relatiunshipImageable;
            $image = $this->$relation()->create([
                'path' => $fullPath,
                'name' => $name,
                'description' => $description,
            ]);
            return $image;
        }catch(Exception $e){
            throw $e;
            // return false;
        }
    }

    public function onlyFileUpload(
        UploadedFile $file,
        string $path,
        string $name = ''
    ): string
    {
        if(!$name){
            $name = uuid_create();
        }
        $path = $this->basePathImageable . '/' . $path;
        $fullPath = $path . '/' . $name . '.'.$file->getClientOriginalExtension();
        $file->storeAs(
            $path,
            $name. '.'.$file->getClientOriginalExtension(),
            $this->diskImageable
        );
        return $fullPath;
    }

    public function deleteFile(string $path):bool
    {
        return Storage::disk($this->diskImageable ?? 'public')
            ->delete($path);
    }
}
