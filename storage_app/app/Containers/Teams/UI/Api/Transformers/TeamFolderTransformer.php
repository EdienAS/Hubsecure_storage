<?php

namespace App\Containers\Teams\UI\Api\Transformers;

use App\Containers\Folders\Models\Folder;
use App\Abstracts\Transformer;

/**
 * Class TeamFolderTransformer.
 *
 */
class TeamFolderTransformer extends Transformer
{

    /**
     * @param \App\Containers\Folders\Models\Folder $folder
     *
     * @return array
     */
    public function transform(Folder $folder)
    {
        return $this->handleData($folder);
    }
    
    /**
     * @return array
     */
    private function handleData($folder)
    { 
        
        unset($folder->updated_at);
        unset($folder->deleted_at);

        $folder->parent = $folder->parent;

        $folder->teamMembers = $folder->teamMembers;
          
        $folder->teamInvitations = $folder->teamInvitations;
          
        $folder->shared = $folder->shared;
          
        foreach($folder['files'] as $key => $file){

            $file->file_url = $file->file_url;

            $file = $file->toArray();

            unset($file['id']);
            unset($file['created_at']);
            unset($file['updated_at']);
            unset($file['deleted_at']);

            $folder['files'][$key] = $file;
        }
        
        foreach($folder['folders'] as $key => $file){

            unset($file['created_at']);
            unset($file['updated_at']);
            unset($file['deleted_at']);

            $folder['folders'][$key] = $file;
        }
        
        $folder = $folder->toArray();
             
        
        return $folder;
    }
}
