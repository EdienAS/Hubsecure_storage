<?php

namespace App\Containers\Files\UI\Api\Transformers;

use App\Abstracts\Transformer;

/**
 * Class FileTransformer.
 *
 */
class FileTransformer extends Transformer
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
