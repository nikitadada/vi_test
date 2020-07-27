<?php declare(strict_types=1);

namespace App\Entity;

/**
 * @Table(name="products")
 * @Entity
 */
class Product
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @Column(type="string", length=255)
     */
    private string $title;

    /**
     * @Column(type="decimal", precision=10, scale=2)
     */
    private string $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }
}
