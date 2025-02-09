<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertOrderRequest;
use Application\UseCases\Order\InsertOrder\DTO\InsertOrderInputDto;
use Application\UseCases\Order\InsertOrder\InsertOrderUseCase;
use Application\UseCases\Order\ShowOrder\DTO\ShowOrderInputDto;
use Application\UseCases\Order\ShowOrder\ShowOrderUseCase;
use Illuminate\Http\Response;

class OrderController extends Controller
{
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


}
