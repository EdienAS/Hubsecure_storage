<?php

namespace App\Containers\Share\UI\Api\Transformers;

use App\Abstracts\Transformer;

/**
 * Class ShareItemPublicTransformer.
 *
 */
class ShareItemPublicTransformer extends Transformer
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
