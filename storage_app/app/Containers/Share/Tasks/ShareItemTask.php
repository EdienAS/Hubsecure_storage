<?php

namespace App\Containers\Share\Tasks;

use Auth;
use Hash;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Models\Folder;
use App\Containers\Share\Resources\ShareResource;
use App\Containers\Share\Exceptions\ShareItemException;

/**
 * Class ShareItemTask.
 *
 */
class ShareItemTask extends Task
{
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {        
        try {
            $item = get_item_by_uuid($request->input('type'), $request->input('item_uuid'));
            
            // Check if item is currently shared
            if ($item->shared()->exists()) {
//                return response()->json([
//                    'type'    => 'error',
//                    'message' => 'The item is currently shared.',
//                ], 422);
                abort(422, 'The item is currently shared.');
            }

            // If sharing folder, check permission attribute
            if ($item instanceof Folder && $request->missing('permission')) {
//                return response()->json([
//                    'type'    => 'error',
//                    'message' => 'The permission field for folder is required.',
//                ], 422);
                abort(422, 'The permission field for folder is required.');
            }
            
            if(Auth::user()->role_id == 1 || Auth::user()->id == $item::find($item->id)->getLatestParent()->user->id){
                
                DB::beginTransaction();

                $shared = Share::create([
                    'uuid'         => $request->input('uuid'),
                    'password'     => $request->has('password') ? Hash::make($request->input('password')) : null,
                    'type'         => $request->input('type') === 'folder' ? 'folder' : 'file',
                    'is_protected' => $request->input('isPassword') ?? false,
                    'permission'   => $request->input('permission') ?? null,
                    'expire_in'    => $request->input('expiration') ?? null,
                    'item_id'      => $item->id,
                    'user_id'      => auth()->id(),
                ]);

                DB::commit();
                
            } else {
                abort(403, 'Unauthorized action.');
            }

        } catch (\Exception $e) {
            throw (new ShareItemException())->debug($e);
        }
        
        return new ShareResource($shared->refresh());
          
    }
    
}
