<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Table(name="orders")
 * @Entity
 */
class Order
{
    const ORDER_STATUS_NEW = 'new';
    const ORDER_STATUS_PAID = 'paid';

    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @Column(type="string", length=255)
     */
    private string $status = self::ORDER_STATUS_NEW;

    /**
     * @ManyToMany(targetEntity="Product")
     * @JoinTable(name="orders_products",
     *      joinColumns={@JoinColumn(name="order_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $products;

    public function __construct() {
        $this->products = new ArrayCollection();
    }

    public function setProducts($products): void
    {
        $this->products = $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getAmount(): float
    {
        $orderAmount = 0;
        foreach ($this->products as $product) {
            $orderAmount += (float) $product->getPrice();
        }

        return $orderAmount;
    }
}
