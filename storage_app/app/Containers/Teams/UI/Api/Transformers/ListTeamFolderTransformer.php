<?php

namespace App\Containers\Teams\UI\Api\Transformers;

use App\Abstracts\Transformer;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListTeamFolderTransformer.
 *
 */
class ListTeamFolderTransformer extends Transformer
{

    /**
     * @return array
     */
    public function transform($folders)
    {
        return $this->handleData($folders);
    }
    
    
    /**
     * @return array
     */
    private function handleData(Collection $folders)
    {
        
        $finalData = array();
        foreach($folders as $folder){
            
            unset($folder->updated_at);
            unset($folder->deleted_at);
            
            foreach($folder['files'] as $key => $file){

                $file->file_url = $file->file_url;

                $file = $file->toArray();

                unset($file['updated_at']);
                unset($file['deleted_at']);

                $folder['files'][$key] = $file;
            }
            
            foreach($folder['folders'] as $key => $file){

                unset($file['updated_at']);
                unset($file['deleted_at']);

                $folder['folders'][$key] = $file;
            }
            
            $finalData[] = $folder;
        }
        
        return $finalData;
    }
}
