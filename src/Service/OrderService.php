<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Exception\AlreadyPaidException;
use App\Exception\BillingException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderService
{
    private EntityRepository $productRepository;
    private EntityRepository $orderRepository;
    private BillingService $billingService;
    private EntityManager $em;

    public function __construct(EntityRepository $productRepository, EntityRepository $orderRepository, BillingService $billingService, EntityManager $em)
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->billingService = $billingService;
        $this->em = $em;
    }

    public function createOrder(array $productIds): Order
    {
        $products = $this->productRepository->findBy([
            'id' => $productIds,
        ]);

        $order = new Order();
        $order->setProducts($products);

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    public function getAndCheckOrder(int $orderId): Order
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($orderId);

        if (!$order) {
            throw new NotFoundHttpException('Order not found');
        }

        if (Order::ORDER_STATUS_NEW !== $order->getStatus()) {
            throw new AlreadyPaidException('Order already paid');
        }

        return $order;
    }

    public function pay(Order $order): void
    {
        if ($this->billingService->pay()) {
            $order->setStatus(Order::ORDER_STATUS_PAID);

            $this->em->persist($order);
            $this->em->flush();
        } else {
            throw new BillingException('Billing error');
        }
    }
}
