<?php

namespace App\Repositories\Eloquent;

use App\Models\BaseModel;
use App\Models\Order;
use App\Repositories\Presenters\PaginationPresenter;
use Domain\Order\Entities\OrderEntity;
use Domain\Order\Enum\OrderStatusEnum;
use Domain\Order\Repositories\IOrderRepository;
use Domain\Share\Exceptions\NotFoundException;
use Domain\Share\Exceptions\RepositoryException;
use Domain\Share\Repositories\IPagination;
use Domain\Share\ValueObjects\Uuid;
use Domain\User\Entities\UserEntity;

class OrderRepository implements IOrderRepository
{

    public function __construct(
        protected Order $orderModel
    ){}

    public function all(array $params = [], array $fields = [], ?int $page = null): IPagination
    {

        $query = $this->orderModel::query();

        if (!empty($fields)) {
            $query->select($fields);
        }

        if (!empty($params['destiny'])) {
            $query->where('destiny', 'LIKE', "%{$params['destiny']}%");
        }

        if (!empty($params['departure_date_ini'])) {
            $query->whereDate('departure_date',  '>=', $params['departure_date_ini']);
        }

        if (!empty($params['departure_date_end'])) {
            $query->whereDate('departure_date',  '<=', $params['departure_date_end']);
        }

        if (!empty($params['return_date_ini'])) {
            $query->whereDate('return_date',  '>=', $params['return_date_ini']);
        }

        if (!empty($params['return_date_end'])) {
            $query->whereDate('return_date',  '<=', $params['return_date_end']);
        }

        if (!empty($params['status'])) {
            $query->where('status_order', $params['status']);
        }
        $paginator = $query->has('user')->with('user')->paginate(perPage: BaseModel::itemsPerPage(),page: $page);

        return new PaginationPresenter($paginator);
    }

    public function insert(OrderEntity $order): void
    {
        try{
             $this->orderModel->create([
                 'id' => $order->id(),
                 'destiny' => $order->destiny,
                 'departure_date' => $order->departureDate->format('Y-m-d'),
                 'return_date' => $order->returnDate->format('Y-m-d'),
                 'status_order' => $order->status->value,
                 'user_id' => $order->user->id
            ]);
        } catch (\Exception $e) {
            throw new RepositoryException('Failed to insert order.');
        }
    }

    public function find(string $id): OrderEntity
    {
        if(!$orderModel = $this->orderModel->has('user')->with('user')->find($id)){
            throw new NotFoundException('Order not found.');
        }

        return $this->toEntity($orderModel);
    }

    private  function toEntity(Order $order): OrderEntity
    {
        $userEntity = new UserEntity();
        $user = $userEntity->fromReadModel($order->user->email, $order->user->name, $order->user->id);
        return new OrderEntity(
            user: $user,
            destiny: $order->destiny,
            departureDate: $order->departure_date,
            returnDate: $order->return_date,
            status: OrderStatusEnum::from($order->status_order),
            created_at: $order->created_at,
            id: new Uuid($order->id)
        );
    }

}
