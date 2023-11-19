<?php

namespace App\Services\Favorites;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class FavoritesService
{
    const DEFAULT_INSTANCE = 'shopping-favorite';

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
     * @param int $id
     * @param string $type
     * @return Collection
     */
    protected function createFavoriteItem(int $id, string $type): Collection
    {
        return collect([
            'id' => $id,
            'type' => $type
        ]);
    }

}
