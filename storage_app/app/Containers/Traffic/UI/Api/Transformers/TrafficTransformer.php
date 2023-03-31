<?php

namespace App\Containers\Traffic\UI\Api\Transformers;

use App\Abstracts\Transformer;
use App\Containers\Traffic\Models\Traffic;

/**
 * Class TrafficTransformer.
 *
 */
class TrafficTransformer extends Transformer
{

    /**
     * @param \App\Containers\Traffic\Models\Traffic $traffic
     *
     * @return array
     */
    public function transform($traffic)
    {
        return $traffic;
    }
    
}
