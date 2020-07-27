<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Exception\InvalidAmountException;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController
{
    private Request $request;
    private OrderService $orderService;

    public function __construct(Request $request, OrderService $orderService)
    {
        $this->request = $request;
        $this->orderService = $orderService;
    }

    public function newAction()
    {
        $productIds = json_decode($this->request->getContent(), true)['productIds'];
        $order = $this->orderService->createOrder($productIds);

        return $this->sendOrderResponse($order);
    }

    public function payAction(int $id)
    {
        $postData = json_decode($this->request->getContent(), true);
        $amount = $postData['amount'];

        $order = $this->orderService->getAndCheckOrder($id);

        if ($order->getAmount() === $amount) {
            $this->orderService->pay($order);
        } else {
            throw new InvalidAmountException('Order amount does not match');
        }

        return $this->sendOrderResponse($order);
    }

    private function sendOrderResponse(Order $order): JsonResponse
    {
        $responseData = [
            'orderId' => $order->getId(),
            'orderStatus' => $order->getStatus(),
        ];

        return new JsonResponse($responseData);
    }
}
