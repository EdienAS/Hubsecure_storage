<?php

namespace App\Containers\Files\Tasks;

use Config;
use App\Abstracts\Task;
use App\Traits\XRPLBlockTrait;
use Illuminate\Support\Facades\Http;
use App\Containers\Files\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\Traffic\Actions\RecordDownloadAction;
use App\Containers\Files\Exceptions\GetFileFailedException;
use App\Containers\XRPLBlock\Tasks\XRPLDownloadDocumentTask;

/**
 * Class DownloadFileTask.
 *
 */
class DownloadFileTask extends Task
{
    use XRPLBlockTrait;
    
    public function __construct(
        private RecordDownloadAction $recordDownload,
    ) {
    }
    
    /**
     * @param $file
     *
     * @return mixed
     */
    public function run(File $file)
    {
        try {
            
            switch ($file->file_storage_option_id){
                case 1:

                    if(!empty($file->xrpl_block_document_id)){
                        
                        $response = resolve(XRPLDownloadDocumentTask::class)($file->xrplBlockDocument->uuid);
                    
                    //Download file from xrpl url once
                    $url = $response['document']['dec_file_uri'];
                    
                    $tempFile = tempnam(sys_get_temp_dir(), $file->name);
                    copy($url, $tempFile);
                    
                    $returnData = response()->download($tempFile, $file->name)->deleteFileAfterSend();
                    
                    } else {

                        // Get file path
                        $temp = (app()->environment() == 'testing') ? 'testing/' : null;
                        $filePath = $temp . "files/$file->user_id/$file->basename";

                        // Check if file exist
                        if (Storage::missing($filePath)) {
                            throw new FileNotFoundException();
                        }

                        // Get pretty name
                        $fileName = getPrettyName($file);

                        // Format response header
                        $header = [
                            'ResponseAcceptRanges'       => 'bytes',
                            'ResponseContentType'        => Storage::mimeType($filePath),
                            'ResponseContentLength'      => Storage::size($filePath),
                            'ResponseContentRange'       => 'bytes 0-600/' . Storage::size($filePath),
                            'ResponseContentDisposition' => 'attachment; filename="' . $fileName . '"',
                        ];

                        // Download file
                        $returnData = Storage::download($filePath, $fileName, $header);

                    }
                    
                    break;

            }
                
            // Store user download size
            ($this->recordDownload)(
                file_size: $file->filesize,
                user_id: $file->user_id,
            );
            
            return $returnData;
        } catch (\Exception $e) {
            throw (new GetFileFailedException())->debug($e);
        }

    }
    
}
