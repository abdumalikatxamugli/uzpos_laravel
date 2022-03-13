<?php
namespace App\Responses;

class CustomPaginatedResponse{
    private $defaultPaginator;
    function __construct($paginator){
        $this->defaultPaginator = $paginator;
    }
    public function json(){
        return response()->json([
            'current'=>$this->defaultPaginator->currentPage(),
            'pageSize'=>$this->defaultPaginator->perPage(),
            'success'=>true,
            'total'=>$this->defaultPaginator->total(),
            'data'=>$this->defaultPaginator->items()
        ], 200);
    }
}
