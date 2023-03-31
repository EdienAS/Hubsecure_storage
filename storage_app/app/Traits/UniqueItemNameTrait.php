<?php   

namespace App\Traits;

use App\Containers\Files\Models\File;
use App\Containers\Folders\Models\Folder;

trait UniqueItemNameTrait
{
    
    public function getUniqueItemName($itemName, $type, $parentFolderid, $isTeamFolder) {
        $name = $itemName;
        $query = [
            'folder' => [
                'where' => [
                    'user_id'     => auth()->id(),
                    'parent_folder_id'   => $parentFolderid,
                    'team_folder'       => $isTeamFolder
                ],
            ],
            'file' => [
                'where' => [
                    'user_id'     => auth()->id(),
                    'parent_folder_id'   => $parentFolderid,
                ],
            ],
        ];
        
        if($type == 'folder'){
            if(Folder::where($query['folder']['where'])
                    ->wherename($name)->exists()){
                $i = 0;
                do {
                    $name = $itemName . '(' . ++$i . ')';
                }  while (Folder::where($query['folder']['where'])
                    ->wherename($name)->exists()); 
            }
        } else {
            
            if(File::where($query['file']['where'])
                    ->wherename($name)->exists()){
                $fullName = explode('.', $itemName);
                $i = 0;
                do {
                    $name = $fullName[0] . '(' . ++$i . ').' . $fullName[1];
                } while (File::where($query['file']['where'])
                    ->wherename($name)->exists()); 
            }
        
        }
        
        return $name;
    }

}
