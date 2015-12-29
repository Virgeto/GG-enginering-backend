<?php


namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Libraries\ResponseBuilder;


abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $response;

    public function __construct(ResponseBuilder $response)
    {
        $this->response = $response;
    }

    /**
     * Create array from relations passed as parameter.
     *
     * @param $input
     * @param string $delimiter
     * @return array
     */
    protected function prepareRelations($input, $delimiter = ',')
    {
        $relations = explode($delimiter, $input);

        return $relations;
    }


}
