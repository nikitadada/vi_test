<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function generateProducts(int $countProducts): array
    {
        $productsIds = [];
        for ($i = 0; $i < $countProducts; $i++) {
            $product = new Product();

            $product->setPrice($this->createRandomPrice());
            $product->setTitle(sprintf('product_%s', $i));

            $this->em->persist($product);
            $this->em->flush();

            $productsIds[] = $product->getId();
        }

        return $productsIds;
    }

    private function createRandomPrice(): string
    {
        return (string) (mt_rand(1000, 9999999) / 100);
    }
}
