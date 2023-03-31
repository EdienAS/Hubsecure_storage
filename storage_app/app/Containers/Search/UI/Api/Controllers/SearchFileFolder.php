<?php

namespace App\Containers\Search\UI\Api\Controllers;

use App\Containers\Search\UI\Api\Requests\SearchFileFolderRequest;

use App\Containers\Search\Actions\SearchFileFolderAction;


use App\Containers\Search\UI\Api\Transformers\SearchFileFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class SearchFileFolder.
 *
 */
class SearchFileFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Search\UI\Api\Requests\SearchFileFolderRequest $request
     * @param \App\Containers\Search\Actions\SearchFileFolderAction      $action
     *
     * @return Response
     */
    public function get(SearchFileFolderRequest $request, SearchFileFolderAction $action)
    {
        return $this->responseItem($action->run($request), new SearchFileFolderTransformer());
    }
    
}
