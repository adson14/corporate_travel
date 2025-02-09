<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertOrderRequest;
use App\Http\Requests\ListOrderRequest;
use Application\UseCases\Order\ApproveOrder\ApproveOrderUseCase;
use Application\UseCases\Order\ApproveOrder\CancelOrderUseCase;
use Application\UseCases\Order\ApproveOrder\DTO\ApproveOrderInputDto;
use Application\UseCases\Order\ApproveOrder\DTO\CancelOrderInputDto;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderInputDto;
use Application\UseCases\Order\InsertOrder\InsertOrderUseCase;
use Application\UseCases\Order\ListOrder\DTO\FilterOrderDto;
use Application\UseCases\Order\ListOrder\DTO\ListOrderInputDto;
use Application\UseCases\Order\ListOrder\ListOrderUseCase;
use Application\UseCases\Order\ShowOrder\DTO\ShowOrderInputDto;
use Application\UseCases\Order\ShowOrder\ShowOrderUseCase;
use Domain\Order\Enum\OrderStatusEnum;
use Illuminate\Http\Response;

class OrderController extends Controller
{

    public function list(ListOrderRequest $request, ListOrderUseCase $useCase)
    {
        $request->validated();
        $filters = new FilterOrderDto(
            destiny: request('destiny') ?? null,
            status: request('status'),
            departure_date_ini: request('departure_date_ini')  ??  null,
            departure_date_end: request('departure_date_end') ?? null,
            return_date_ini: request('return_date_ini') ?? null,
            return_date_end: request('return_date_end') ?? null
        );
        $page = request('page') ?? 1;
        $input = new ListOrderInputDto(page:$page, filters: $filters);
        $output = (array) $useCase->execute($input);
        $output['options'] = $this->options();
        return response()->json($output)->setStatusCode(Response::HTTP_OK);
    }

    public function create(InsertOrderRequest $request, InsertOrderUseCase $useCase)
    {
        $response = $useCase->execute(
            new InsertOrderInputDto(
                user_id: $request->user_id,
                destiny: $request->destiny,
                departure_date: $request->departure_date,
                return_date: $request->return_date
            )
        );
        return response()->json($response)->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ShowOrderUseCase $useCase, string $id)
    {
        $response = $useCase->execute(
            new ShowOrderInputDto(
                order_id: $id
            )
        );
        return response()->json($response)->setStatusCode(Response::HTTP_OK);
    }

    public function cancel(CancelOrderUseCase $useCase, string $id)
    {
        $response = $useCase->execute(
            new CancelOrderInputDto(
                order_id: $id
            )
        );
        return response()->json($response)->setStatusCode(Response::HTTP_CREATED);
    }

    public function approve(ApproveOrderUseCase $useCase, string $id)
    {
        $response = $useCase->execute(
            new ApproveOrderInputDto(
                order_id: $id
            )
        );
        return response()->json($response)->setStatusCode(Response::HTTP_CREATED);
    }

    public function options()
    {
        return [
            'status' => OrderStatusEnum::toArray()
        ];
    }
}
