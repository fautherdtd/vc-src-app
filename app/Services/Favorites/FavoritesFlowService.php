<?php

namespace App\Services\Favorites;

use Illuminate\Support\Collection;

class FavoritesFlowService extends FavoritesService
{
    /**
     * Adds a new item to the cart.
     *
     * @param int $id
     * @return void
     */
    public function add(int $id, string $type): void
    {
        $cartItem = $this->createFavoriteItem($id, $type);

        $content = $this->getContent();

        if (! $content->has($id)) {
            $content->put($id, $cartItem);
            $this->session->put(self::DEFAULT_INSTANCE, $content);
        } else {
            $this->remove($id);
        }
    }

    /**
     * Removes an item from the cart.
     *
     * @param string $id
     * @return void
     */
    public function remove(string $id): void
    {
        $content = $this->getContent();

        if ($content->has($id)) {
            $this->session->put(self::DEFAULT_INSTANCE, $content->except($id));
        }
    }

    /**
     * Clears the cart.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->session->forget(self::DEFAULT_INSTANCE);
    }

    /**
     * Returns the content of the cart.
     *
     * @return Collection
     */
    public function content(): Collection
    {
        return is_null($this->session->get(self::DEFAULT_INSTANCE)) ?
            collect([]) :
            $this->session->get(self::DEFAULT_INSTANCE);
    }
    /**
     * Returns total quantity of the items in the cart.
     *
     * @return int
     */
    public function totalQuantity(): int
    {
        $content = $this->getContent();

        return $content->count();
    }
}
