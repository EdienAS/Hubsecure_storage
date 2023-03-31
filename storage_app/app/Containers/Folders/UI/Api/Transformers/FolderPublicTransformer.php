<?php

namespace App\Containers\Folders\UI\Api\Transformers;

use App\Abstracts\Transformer;

/**
 * Class FolderPublicTransformer.
 *
 */
class FolderPublicTransformer extends Transformer
{

    /**
     * @param $data
     *
     * @return array
     */
    public function transform($data)
    {
        return $data;
    }
    
}
