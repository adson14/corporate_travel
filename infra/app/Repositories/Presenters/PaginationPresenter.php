<?php

namespace App\Repositories\Presenters;

use Domain\Share\Repositories\IPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationPresenter implements IPagination
{

    protected $items = [];
    public function __construct(
        protected LengthAwarePaginator $paginator
    ){

        $this->items = $this->resolve($this->paginator->items());
    }


    public function items(): array
    {
        return $this->items;
    }

    public function total() : int
    {
        return $this->paginator->total() ?? 0;
    }


    public function lastPage() : int
    {
        return $this->paginator->lastPage() ?? 0;
    }


    public function currentPage() : int
    {
        return $this->paginator->currentPage() ?? 0;
    }

    public function firstPage() : int
    {
        return $this->paginator->firstItem() ?? 0;
    }


    public function perPage() : int
    {
        return $this->paginator->perPage() ?? 0;
    }


    public function to() : int
    {
        return $this->paginator->firstItem() ?? 0;
    }


    public function from() : int
    {
        return $this->paginator->lastItem() ?? 0;
    }

    public function resolve(array $items) :array
    {
        $response = [];
        foreach ($items as $item) {
            $stdClass = new \stdClass();
            foreach ($item->toArray() as $key => $value) {
                $stdClass->{$key} = $value;
            }
            array_push($response, $stdClass);
        }
        return $response;
    }
}
