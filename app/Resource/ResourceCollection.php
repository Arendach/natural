<?php

namespace App\Resource;

use Countable;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use IteratorAggregate;

class ResourceCollection extends Resource implements Countable, IteratorAggregate
{
    public string $collects;

    public ?Collection $collection = null;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    public function toArray(): array
    {
        return $this->collection->map->toArray()->all();
    }

    public function __toString(): string
    {
        return json_encode(
            $this->collection->toArray(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    protected function collectResource($resource)
    {
        if ($resource instanceof MissingValue) {
            return $resource;
        }

        if (is_array($resource)) {
            $resource = new Collection($resource);
        }

        $collects = $this->collects();

        $this->collection = $collects && ! $resource->first() instanceof $collects
            ? $resource->mapInto($collects)
            : $resource->toBase();

        return ($resource instanceof AbstractPaginator || $resource instanceof AbstractCursorPaginator)
            ? $resource->setCollection($this->collection)
            : $this->collection;
    }

    /**
     * Get the resource that this resource collects.
     *
     * @return string|null
     */
    protected function collects()
    {
        $collects = null;

        if ($this->collects) {
            $collects = $this->collects;
        } elseif (str_ends_with(class_basename($this), 'Collection') &&
            (class_exists($class = Str::replaceLast('Collection', '', get_class($this))) ||
                class_exists($class = Str::replaceLast('Collection', 'Resource', get_class($this))))) {
            $collects = $class;
        }

        if (! $collects || is_a($collects, Resource::class, true)) {
            return $collects;
        }

        throw new \LogicException('Resource collections must collect instances of '.Resource::class.'.');
    }

    public function jsonOptions(): int
    {
        $collects = $this->collects();

        if (! $collects) {
            return 0;
        }

        return (new \ReflectionClass($collects))
            ->newInstanceWithoutConstructor()
            ->jsonOptions();
    }

    public function getIterator(): \Traversable
    {
        return $this->collection->getIterator();
    }
}
