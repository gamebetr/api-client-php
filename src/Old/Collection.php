<?php

namespace Gamebetr\ApiClient;

use Countable;
use Gamebetr\ApiClient\Contracts\ApiContract;
use Iterator;

class Collection implements Countable, Iterator
{
    /**
     * Api object.
     * @var \Gamebetr\ApiClient\Contracts\ApiContract
     */
    protected $api;

    /**
     * Endpoint.
     * @var string
     */
    protected $endpoint;

    /**
     * Query.
     * @var array
     */
    protected $query;

    /**
     * Limit.
     * @var int
     */
    protected $limit = 100;

    /**
     * Offset.
     * @var int
     */
    protected $offset = 0;

    /**
     * Items.
     * @var array
     */
    public $items = [];

    /**
     * Class constructor.
     * @param \Gamebetr\ApiClient\Contracts\ApiContract $api
     * @param array $items
     * @return void
     */
    public function __construct(
        ApiContract $api,
        string $endpoint,
        array $query
    ) {
        $this->api = $api;
        $this->endpoint = $endpoint;
        $this->query = $query;
        // $this->limit = 100;
        // $this->offset = 0;
        $this->fill();
    }

    /**
     * Next page.
     * @return self|null
     */
    public function nextPage() : ?self
    {
        $this->items = [];
        $this->offset = $this->offset + $this->limit;
        $this->fill();
        if (empty($this->items)) {
            return null;
        }

        return $this;
    }

    /**
     * Previous page.
     * @return self|null
     */
    public function previousPage() : ?self
    {
        $this->items = [];
        $this->offset = $this->offset - $this->limit;
        if ($this->offset < 0) {
            return null;
        }
        $this->fill();
        if (empty($this->items)) {
            return null;
        }

        return $this;
    }

    /**
     * Count.
     * @return int
     */
    public function count() : int
    {
        return count($this->items);
    }

    /**
     * Fill data.
     * @return void
     */
    private function fill()
    {
        // $request = $this->api->request($this->endpoint, 'GET', [], true, [], ['limit' => $this->limit, 'offset' => $this->offset, 'include' => 'images']);
        $query = ['limit' => $this->limit, 'offset' => $this->offset];
        if (!empty($this->query)) {
            $query += $this->query;
        }
        $request = $this->api->request($this->endpoint, 'GET', [], true, [], $query);
        foreach ($request->getResponse()->data as $apiObject) {
            // removed objectClass to allow tags and related arrays to be included in results
            $this->items[] = $apiObject;
        }
    }

    /**
     * Rewind.
     * @return void
     */
    public function rewind()
    {
        reset($this->items);
    }

    /**
     * Current.
     * @return mixed
     */
    public function current()
    {
        $current = current($this->items);

        return $current;
    }

    /**
     * Key.
     * @return mixed
     */
    public function key()
    {
        $key = key($this->items);

        return $key;
    }

    /**
     * Next.
     * @return mixed
     */
    public function next()
    {
        $next = next($this->items);

        return $next;
    }

    /**
     * Valid.
     * @return bool
     */
    public function valid()
    {
        $key = key($this->var);

        return $key !== null && $key !== false;
    }
}
