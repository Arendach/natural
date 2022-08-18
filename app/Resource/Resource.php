<?php

namespace App\Resource;

use Illuminate\Contracts\Support\Responsable;
use Countable;
use ArrayAccess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;
use Stringable;

class Resource implements ArrayAccess, Countable, JsonSerializable, Responsable, Stringable
{
    use ConditionallyLoadsAttributes;

    use ForwardsCalls, Macroable {
        __call as macroCall;
    }

    public mixed $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public static function collection($resource)
    {
        return tap(new AnonymousResourceCollection($resource, static::class), function () {
        });
    }

    public function __get($key)
    {
        return $this->resource->{$key};
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}(...$parameters);
        }

        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->forwardCallTo($this->resource, $method, $parameters);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->resource[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->resource[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->resource[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->resource[$offset]);
    }

    public function count(): int
    {
        return count($this->resource);
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->resource);
    }

    public function jsonSerialize()
    {
        return $this->resource->toArray();
    }

    public function toArray(): array
    {
        return $this->resource->toArray();
    }

    public function __toString(): string
    {
        return json_encode(
            $this->toArray(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
}