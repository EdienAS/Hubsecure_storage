<?php

namespace App\Containers\Browse\UI\Api\Transformers;

use App\Abstracts\Transformer;

/**
 * Class BrowseSharedWithMeTransformer.
 *
 */
class BrowseSharedWithMeTransformer extends Transformer
{

    /**
     * @param \App\Containers\Teams\Models\TeamFolderInvitation $data
     *
     * @return array
     */
    public function transform($data)
    {
        return $data;
    }
}
