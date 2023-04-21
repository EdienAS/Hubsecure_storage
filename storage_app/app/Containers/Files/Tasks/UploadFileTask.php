<?php

namespace App\Containers\Files\Tasks;

use Auth;
use Exception;
use App\Abstracts\Task;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Traits\UniqueItemNameTrait;
use App\Containers\Files\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Containers\Folders\Models\Folder;
use League\Flysystem\UnableToRetrieveMetadata;
use App\Containers\Files\Resources\FileResource;
use App\Containers\XRPLBlock\Tasks\XRPLCreateBlockTask;
use App\Containers\Files\Tasks\StoreFileToLocalDiskTask;
use App\Containers\XRPLBlock\Tasks\StoreFileXRPLBlockTask;
use App\Containers\Files\Exceptions\UploadFileFailedException;

/**
 * Class UploadFileTask.
 *
 */
class UploadFileTask extends Task
{
    use UniqueItemNameTrait;
    

    /**
     * @var  StoreFileToLocalDiskTask
     */
    private $storeFileLocalTask;
       
    /**
     * @var  XRPLCreateBlockTask
     */
    private $xrplCreateBlockTask;
     
    /**
     * @var  StoreFileXRPLBlockTask
     */
    private $storeFileXRPLBlockTask;
    
    
    public function __construct(
        StoreFileToLocalDiskTask $storeFileLocalTask,
        XRPLCreateBlockTask $xrplCreateBlockTask,
        StoreFileXRPLBlockTask $storeFileXRPLBlockTask,
        public GetFileParentFolderId $getFileParentFolderId,
        public StoreExifDataTask $storeExifDataTask,
        public ProcessImageThumbnailTask $createImageThumbnailTask,
    ) {
        $this->storeFileLocalTask = $storeFileLocalTask;
        $this->xrplCreateBlockTask = $xrplCreateBlockTask;
        $this->storeFileXRPLBlockTask = $storeFileXRPLBlockTask;
    }
    
    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run($request)
    {
        try {
            
            $data = $request->all();
            
            // Get stuff
            $isFilledParentFolderId = isset($data['parent_folder_id']) ? true : false;
            $parentFolderId = isset($data['parent_folder_id']) ? $data['parent_folder_id'] : null;
            
            // Get user
            $user = $isFilledParentFolderId
                ? Folder::find($parentFolderId)->getLatestParent()->user
                : Auth::user();
            
            $finalArray = array();
            
            foreach($request->file()['files'] as $file){
                $extension = $file->extension();

                // Get file name
                $name = Str::uuid() . '.' . $extension;

                // Put file to user directory
                $this->storeFileLocalTask->run($file, $user, $name);
                
                // Get local disk instance
                $localDisk = Storage::disk('public');

                // Get file path
                $temp = (app()->environment() == 'testing') ? 'testing/' : null;
                $filePath = $temp . "files/$user->id/$name";
                
                // Get file size
                $size = $localDisk->size($filePath);

                // Get upload limit size
                $uploadLimit = get_settings('upload_limit');
                
                //Get total uploaded file sizes
                $totalUploadedsize = get_total_uploaded_file_size($user->id);
                
                // Get mimetype
                try {
                    $fileType = getFileType(
                        $localDisk->mimeType($filePath)
                    );
                } catch (UnableToRetrieveMetadata $e) {
                    $fileType = 'file';
                }

                // File size handling
                if ($uploadLimit && $size > toBytes($uploadLimit)) {
                    
                    $localDisk->delete($filePath);
                    
                    abort(413, 'File size exceeds upload limit');
                }
                
                //Total uploading size handling
                if($totalUploadedsize > toBytes($user->userSettings->storage_limit_mb)){
                    
                    $localDisk->delete($filePath);
                    
                    abort(413, 'Total stoarge limit has been reached.');
                }
                
                if ($fileType === 'image') {
                    // Create multiple image thumbnails
                    $this->createImageThumbnailTask->run($name, $user->id);

                    // Store exif data if exists
                    $exif = $this->storeExifDataTask->run($filePath);
                }
                $fileHash = hash('sha256', Storage::get($filePath));
                
                //XRPL Block
                $xrplBlockDocument = $this->storeFileXRPLBlockTask->run($filePath);
                
                $localDisk->delete("files/$user->id/$name");

                DB::beginTransaction();

                    $uploadedFile = File::create([
                        'uuid'       => $data['uuid'],
                        'mimetype'   => $extension,
                        'type'       => $fileType,
                        'parent_folder_id'  => ($this->getFileParentFolderId)($request, $user->id),
                        'name'       => $this->getUniqueItemName($file->getClientOriginalName(), 
                                            'file', ($this->getFileParentFolderId)($request, $user->id),
                                            false
                                        ),
                        'basename'   => $name,
                        'filesize'   => $size,
                        'user_id'    => $user->id,
                        'creator_id' => auth()->check() ? auth()->id() : $user->id,
                        'file_storage_option_id' => $user->userSettings->file_storage_option_id,
                        'file_hash' => $fileHash,
                        'xrpl_block_document_id' => $xrplBlockDocument->id
                    ]);

                    if ($fileType === 'image') {
                        $exif?->update(['file_id' => $uploadedFile->id]);
                    }

                DB::commit();
                
                
                ($this->xrplCreateBlockTask)(array($uploadedFile->xrplBlockDocument));
            
                
                $finalArray[] = new FileResource($uploadedFile);
            }

            return $finalArray;

        } catch (Exception $e) {
            
            throw (new UploadFileFailedException())->debug($e);
        }

    }

}
