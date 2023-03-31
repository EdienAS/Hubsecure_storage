<?php

namespace App\Containers\Files\UI\Api\Transformers;

use App\Abstracts\Transformer;

/**
 * Class FilePublicTransformer.
 *
 */
class FilePublicTransformer extends Transformer
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
