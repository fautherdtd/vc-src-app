<?php

namespace App\Services\Cart;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class CartService
{
    const MINIMUM_QUANTITY = 1;
    const DEFAULT_INSTANCE = 'shopping-cart';

    protected SessionManager $session;
    protected $instance;

    /**
     * Constructs a new cart object.
     *
     * @param SessionManager $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }


    /**
     * Returns the content of the cart.
     *
     * @return Collection
     */
    protected function getContent(): Collection
    {
        return $this->session->has(self::DEFAULT_INSTANCE) ?
            $this->session->get(self::DEFAULT_INSTANCE) : collect([]);
    }

    /**
     * Creates a new cart item from given inputs.
     *
     * @param string $name
     * @param string $price
     * @param string $quantity
     * @param array $options
     * @return Collection
     */
    protected function createCartItem(string $name, string $price, string $quantity, array $options): Collection
    {
        $price = floatval($price);
        $quantity = intval($quantity);

        if ($quantity < self::MINIMUM_QUANTITY) {
            $quantity = self::MINIMUM_QUANTITY;
        }

        return collect([
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'options' => $options,
        ]);
    }

}
