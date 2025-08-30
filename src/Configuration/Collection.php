<?php

/**
 * Playground
 */
declare(strict_types=1);

namespace Playground\Make\Postman\Configuration;

use Playground\Make\Configuration;

/**
 * \Playground\Make\Postman\Configuration\Postman\Collection
 */
class Collection extends Configuration\Configuration
{
    protected ?Info $info = null;

    /**
     * @var array<string, Folder>
     */
    protected array $folders = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'info' => null,
        'item' => [],
    ];

    /**
     * @param  array<string, mixed>  $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['auth'])
            && is_array($options['auth'])
        ) {
            // TODO add authentication step here
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$options' => $options,
            //     '$this' => $this,
            // ]);
        }

        if (! empty($options['info'])
            && is_array($options['info'])
        ) {
            $this->info = new Info($options['info']);
            $this->info->apply();
        }

        if (! empty($options['folders'])
            && is_array($options['folders'])
        ) {
            foreach ($options['folders'] as $key => $folder) {
                if ($key && is_string($key) && is_array($folder)) {
                    $this->addFolder($key, $folder);
                }
            }
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$options' => $options,
        //     '$this' => $this,
        // ]);

        return $this;
    }

    // /**
    //  * @param array<string, string> $meta
    //  */
    // public function addComponents(array $meta): self
    // {
    //     // dump([
    //     //     '__METHOD__' => __METHOD__,
    //     //     '$meta' => $meta,
    //     //     '$this' => $this,
    //     // ]);

    //     if (empty($this->components)) {
    //         $this->components = new Components($meta);
    //     } else {
    //         if (! empty($meta['schemas'])
    //             && is_array($meta['schemas'])
    //         ) {
    //             $this->components->addSchemas($meta['schemas']);
    //         }
    //     }

    //     $this->components->apply();

    //     return $this;
    // }

    // /**
    //  * @param array<string, string> $meta
    //  */
    // public function addControllers(array $meta): self
    // {
    //     foreach ($meta as $key => $value) {
    //         if ($key && is_string($key)) {
    //             $this->addController(
    //                 $key,
    //                 is_array($value) ? $value : []
    //             );
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @param array<string, string> $meta
    //  */
    // public function addController(string $controller, array $meta): self
    // {
    //     if (empty($this->controllers[$controller])) {
    //         $this->controllers[$controller] = new Controller;
    //         if ($this->skeleton()) {
    //             $this->controllers[$controller]->withSkeleton();
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @param  array<string, string>  $options
     */
    public function addAuthenticationSteps(array $options = []): self
    {
        // TODO add Authentication Steps handling

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$optionsath' => $options,
        //     // '$this' => $this,
        // ]);
        return $this;
    }

    public function addFolder(string $key, array $options = []): self
    {
        // TODO add folder handling
        // $this->folders[$key] = new Folder($options);

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$key' => $key,
        //     '$options' => $options,
        //     // '$this' => $this,
        // ]);
        return $this;
    }

    public function info(): ?Info
    {
        return $this->info;
    }

    // public function components(): Components
    // {
    //     if (empty($this->components)) {
    //         $this->components = new Components;
    //         if ($this->skeleton()) {
    //             $this->components->withSkeleton();
    //         }
    //     }

    //     return $this->components;
    // }

    // /**
    //  * @return array<string, Controller>
    //  */
    // public function controllers(): array
    // {
    //     return $this->controllers;
    // }

    // public function controller(string $controller): Controller
    // {
    //     if (empty($this->controllers[$controller])) {
    //         $this->controllers[$controller] = new Controller;
    //         if ($this->skeleton()) {
    //             $this->controllers[$controller]->withSkeleton();
    //         }
    //     }

    //     return $this->controllers[$controller];
    // }

    /**
     * @return array<string, Folder>
     */
    public function folders(): array
    {
        return $this->folders;
    }

    public function jsonSerialize(): mixed
    {
        $properties = [];

        $properties['info'] = $this->info()?->toArray();

        $folders = $this->folders();
        if ($folders) {
            $properties['item'] = [];
            foreach ($folders as $path => $folder) {
                $properties['item'][] = $folder->toArray();
            }
        }

        // $properties['components'] = $this->components()->toArray();

        // $controllers = $this->controllers();

        // if ($controllers) {
        //     $properties['paths'] = [];
        //     foreach ($controllers as $name => $controller) {
        //         foreach ($controller->keys() as $method) {
        //             $properties['paths'][${$method}->path()] = [
        //                 '$ref' => ${$method}->ref(),
        //             ];
        //         }
        //     }
        // }

        // dump([
        //     '$properties' => $properties,
        //     '$this' => $this,
        // ]);

        return $properties;
    }
}
