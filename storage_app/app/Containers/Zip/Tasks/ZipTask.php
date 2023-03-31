<?php

namespace App\Containers\Zip\Tasks;

use Gate;
use App\Abstracts\Task;
use Illuminate\Support\Str;
use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\Storage;
use STS\ZipStream\ZipStreamFacade as Zip;
use App\Containers\Folders\Models\Folder;
use App\Containers\Zip\Exceptions\ZipException;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\XRPLBlock\Tasks\XRPLDownloadDocumentTask;

/**
 * Class ZipTask.
 *
 */
class ZipTask extends Task
{
    use XRPLBlockTrait;
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($folders, $files)
    {
        try {
            // Get zip name from single requested folder
            if ($files->isEmpty() && $folders->count() === 1) {
                $zipName = Str::slug($folders->first()->name) . '.zip';
            }
            
            // Create zip
            $zip = Zip::create($zipName ?? date('YmdHis').'_'.env('APP_NAME').'.zip');

            // Zip Files
            $files->map(function ($file) use ($zip) {
                
                // Check user privileges to the file
                if (! Gate::any(['can-edit', 'can-view'], [$file, null])) {
                    abort(403, 'Unauthorized action.');
                }

                switch ($file->file_storage_option_id) {
                    case 1:

                    if(!empty($file->xrpl_block_document_id)){
                        
                        $response = resolve(XRPLDownloadDocumentTask::class)($file->xrplBlockDocument->uuid);
                    
                        //Download file from xrpl url once
                        $url = $response['document']['dec_file_uri'];

                        $tempFile = tempnam(sys_get_temp_dir(), $file->name);
                        copy($url, $tempFile);

                        $download_file = file_get_contents($tempFile);
                        
                        unlink($tempFile);
                                
                        $zip->add($download_file, $file->name);
                    } else {

                        // get file path
                        $filePath = "files/$file->user_id/$file->basename";

                        // Add file into zip
                        if (Storage::exists($filePath)) {
                            $zip->add(Storage::path($filePath), $file->name);
                        }
                    }
                        break;
                    
                    default:
                        abort(409, "Invalid storage option: " . $file->file_storage_option_id);
                }
            });
            
            // Zip Folders
            $folders->map(function ($folder) use ($zip) {

                // Check user privileges to the folder
                if (! Gate::any(['can-edit', 'can-view'], [$folder, null])) {
                    abort(403, 'Unauthorized action.');
                }

                // Get folder
                $requested_folder = Folder::with(['folders.files', 'files'])
                    ->where('id', $folder->id)
                    ->with('folders')
                    ->first();

                $folderFiles = get_files_for_zip($requested_folder, collect([]));

                foreach ($folderFiles as $file) {
                    $zipDestination = "{$file['folder_path']}/{$file['name']}";
                    switch ($file['file_storage_option_id']) {
                        case 1:
                            if(!empty($file['xrpl_block_document_id'])){
                                
                                $response = resolve(XRPLDownloadDocumentTask::class)($file['xrplBlockDocument']['uuid']);
                    
                                //Download file from xrpl url once
                                $url = $response['document']['dec_file_uri'];

                                $tempFile = tempnam(sys_get_temp_dir(), $file['name']);
                                copy($url, $tempFile);

                                $download_file = file_get_contents($tempFile);
                                
                                unlink($tempFile);
                                
                                $zip->add($download_file, $zipDestination);
                            } else {
                                // get file path
                                $filePath = "files/{$file['user_id']}/{$file['basename']}";

                                // Add file into zip
                                if (Storage::exists($filePath)) {

                                    // local disk
                                    if (isStorageDriver('public')) {

                                        $zip->add(Storage::path($filePath), $zipDestination);
                                    }
                                }
                            }   
                            break;

                        default:
                            abort(409, "Invalid storage option: " . $file->file_storage_option_id);
                    }
                }
            });
            
        } catch (\Exception $e) {
            throw (new ZipException())->debug($e);
        }
        
        return $zip;
          
    }
    
}
