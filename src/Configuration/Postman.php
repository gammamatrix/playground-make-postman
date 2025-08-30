<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Postman\Configuration;

use Playground\Make\Configuration\PrimaryConfiguration;

/**
 * \Playground\Make\Postman\Configuration\Postman
 */
class Postman extends PrimaryConfiguration
{
    protected string $description = '';

    // protected string $model_fqdn = '';

    // protected string $model_column = '';

    // protected string $model_label = '';

    // protected string $model_slug_plural = '';

    // protected string $model_file = '';

    // protected string $model_revision_file = '';

    protected string $model_package = '';

    protected string $controller_package = '';

    protected string $_postman_id = '';

    protected string $schema = '';

    protected string $_exporter_id = '';

    protected string $_collection_link = '';

    protected bool $withAuthSanctum = false;

    protected bool $withAuthSession = false;

    /**
     * @var array<string, string>
     */
    protected array $models = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        // 'class' => '',
        // 'config' => '',
        // 'fqdn' => '',
        // 'model' => '',
        // 'model_fqdn' => '',
        // 'model_column' => '',
        // 'model_label' => '',
        // 'model_slug_plural' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'description' => '',
        'namespace' => '',
        'organization' => '',
        'package' => '',
        // properties
        'models' => [],
        // 'folder' => '',
        'type' => '',
        // 'model_file' => '',
        // 'model_revision_file' => '',
        'model_package' => '',
        'controller_package' => '',
        // collection
        'withAuthSanctum' => false,
        'withAuthSession' => false,
        '_postman_id' => '',
        'schema' => '',
        '_exporter_id' => '',
        '_collection_link' => '',
    ];

    /**
     * @param  array<string, mixed>  $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (array_key_exists('withAuthSanctum', $options)) {
            $this->withAuthSanctum = ! empty($options['withAuthSanctum']);
        }

        if (array_key_exists('withAuthSession', $options)) {
            $this->withAuthSession = ! empty($options['withAuthSession']);
        }

        // if (! empty($options['model_fqdn'])
        //     && is_string($options['model_fqdn'])
        // ) {
        //     $this->model_fqdn = $options['model_fqdn'];
        // }

        // if (! empty($options['model_column'])
        //     && is_string($options['model_column'])
        // ) {
        //     $this->model_column = $options['model_column'];
        // }

        // if (! empty($options['model_label'])
        //     && is_string($options['model_label'])
        // ) {
        //     $this->model_label = $options['model_label'];
        // }

        // if (! empty($options['model_slug_plural'])
        //     && is_string($options['model_slug_plural'])
        // ) {
        //     $this->model_slug_plural = $options['model_slug_plural'];
        // }

        // TODO is folder needed?
        // if (! empty($options['folder'])
        //     && is_string($options['folder'])
        // ) {
        //     $this->folder = $options['folder'];
        // }

        if (! empty($options['description'])
            && is_string($options['description'])
        ) {
            $this->description = $options['description'];
        }

        // if (! empty($options['model_file'])
        //     && is_string($options['model_file'])
        // ) {
        //     $this->model_file = $options['model_file'];
        // }

        // if (! empty($options['model_revision_file'])
        //     && is_string($options['model_revision_file'])
        // ) {
        //     $this->model_revision_file = $options['model_revision_file'];
        // }

        if (! empty($options['model_package'])
            && is_string($options['model_package'])
        ) {
            $this->model_package = $options['model_package'];
        }

        if (! empty($options['controller_package'])
            && is_string($options['controller_package'])
        ) {
            $this->controller_package = $options['controller_package'];
        }

        if (! empty($options['_postman_id'])
            && is_string($options['_postman_id'])
        ) {
            $this->_postman_id = $options['_postman_id'];
        }

        if (! empty($options['schema'])
            && is_string($options['schema'])
        ) {
            $this->schema = $options['schema'];
        }

        if (! empty($options['_exporter_id'])
            && is_string($options['_exporter_id'])
        ) {
            $this->_exporter_id = $options['_exporter_id'];
        }

        if (! empty($options['_collection_link'])
            && is_string($options['_collection_link'])
        ) {
            $this->_collection_link = $options['_collection_link'];
        }

        $this->addModels($options);

        return $this;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function addModels(array $options): self
    {
        if (! empty($options['models'])
            && is_array($options['models'])
        ) {
            foreach ($options['models'] as $key => $file) {
                $this->addMappedClassTo('models', $key, $file);
            }
        }

        return $this;
    }

    // public function model_fqdn(): string
    // {
    //     return $this->model_fqdn;
    // }

    // public function model_file(): string
    // {
    //     return $this->model_file;
    // }

    // public function model_revision_file(): string
    // {
    //     return $this->model_revision_file;
    // }

    public function description(): string
    {
        return $this->description;
    }

    public function model_package(): string
    {
        return $this->model_package;
    }

    public function controller_package(): string
    {
        return $this->controller_package;
    }

    public function _postman_id(): string
    {
        return $this->_postman_id;
    }

    public function schema(): string
    {
        return $this->schema;
    }

    public function _exporter_id(): string
    {
        return $this->_exporter_id;
    }

    public function _collection_link(): string
    {
        return $this->_collection_link;
    }

    /**
     * @return array<string, string>
     */
    public function models(): array
    {
        return $this->models;
    }

    public function withAuthSanctum(): bool
    {
        return $this->withAuthSanctum;
    }

    public function withAuthSession(): bool
    {
        return $this->withAuthSession;
    }
}
