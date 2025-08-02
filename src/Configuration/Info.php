<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Make\Postman\Configuration;

use Playground\Make\Configuration;

/**
 * \Playground\Make\Postman\Configuration\Info
 */
class Info extends Configuration\Configuration
{
    protected string $_postman_id = '';

    protected string $name = '';

    protected string $schema = 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json';

    protected string $_exporter_id = '';

    // protected string $_collection_link = 'https://www.postman.com/gammamatrix/workspace/playground/collection/1185343-1e4a5656-d4e0-45b2-8f4e-daad7a6ee2b1?action=share&source=collection_link&creator=1185343';
    protected string $_collection_link = '';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        '_postman_id' => '',
        'name' => '',
        'schema' => '',
        '_exporter_id' => '',
        '_collection_link' => '',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['_postman_id'])
            && is_string($options['_postman_id'])
        ) {
            $this->_postman_id = $options['_postman_id'];
        }

        if (! empty($options['name'])
            && is_string($options['name'])
        ) {
            $this->name = $options['name'];
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

        return $this;
    }

    public function _postman_id(): string
    {
        return $this->_postman_id;
    }

    public function name(): string
    {
        return $this->name;
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
}
