<?php

/**
 * Copyright 2019 Alex <blldxt@gmail.com>
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace ConstanzeStandard\Fluff\Interfaces;

use ConstanzeStandard\Routing\Interfaces\RouteCollectionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface RouterInterface extends RouteHelperInterface
{
    /**
     * Get the route collection.
     * 
     * @return RouteCollectionInterface
     */
    public function getRouteCollection(): RouteCollectionInterface;

    /**
     * Create a route group.
     * 
     * @param callable $callback
     * @param string $prefix
     * @param MiddlewareInterface[] $middlewares
     * 
     * @return RouteGroupInterface
     */
    public function group(callable $callback, string $prefix = '', array $middlewares = []): RouteGroupInterface;

    /**
     * Add a router middleware.
     * 
     * @param MiddlewareInterface $middleware
     * 
     * @return MiddlewareInterface
     */
    public function addMiddleware(MiddlewareInterface $middleware): MiddlewareInterface;

    /**
     * Add a route to collection.
     * 
     * @param RouteInterface $route
     * 
     * @return RouteInterface
     */
    public function addRoute(RouteInterface $route): RouteInterface;

    /**
     * Register route data to collection.
     *
     * @param array|string $methods
     * @param string $pattern
     * @param \Closure|array|string $handler
     * @param MiddlewareInterface[] $middlewares
     * @param string|null $name
     * 
     * @return RouteInterface
     */
    public function add($methods, string $pattern, $handler, array $middlewares = [], string $name = null): RouteInterface;

    /**
     * Create a route group.
     * 
     * @param string $prefix
     * @param MiddlewareInterface[] $middlewares
     * 
     * @return RouteGroupInterface
     */
    public function deriveGroup(string $prefix = '', array $middlewares = []): RouteGroupInterface;

    /**
     * Set group prefix.
     * 
     * @param string $prefix
     * 
     * @return self
     */
    public function setPrefix(string $prefix);

    /**
     * Get the root route group.
     * 
     * @return RouteGroupInterface
     */
    public function getRootGroup(): RouteGroupInterface;

    /**
     * Get the routeService.
     * 
     * @return RouteServiceInterface
     */
    public function getRouteService(): RouteServiceInterface;

    /**
     * Match request or fail.
     * 
     * @param ServerRequestInterface $request
     * 
     * @return array [$options, $routeHandler, $arguments]
     * 
     * @throws HttpMethodNotAllowedException
     * @throws HttpNotFoundException
     */
    public function matchOrFail(ServerRequestInterface $request): array;
}
