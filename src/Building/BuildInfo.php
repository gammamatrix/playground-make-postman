<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Postman\Building;

/**
 * \Playground\Make\Postman\Building\BuildInfo
 */
trait BuildInfo
{
    public function build_collection_info(): void
    {
        $options = [
            'name' => $this->c->name(),
        ];

        if ($this->c->_postman_id()) {
            $options['_postman_id'] = $this->c->_postman_id();
        }

        if ($this->c->schema()) {
            $options['schema'] = $this->c->schema();
        }

        if ($this->c->_exporter_id()) {
            $options['_exporter_id'] = $this->c->_exporter_id();
        }

        if ($this->c->_collection_link()) {
            $options['_collection_link'] = $this->c->_collection_link();
        }

        $this->collection->setOptions([
            'info' => $options,
        ]);

        $this->collection->info()?->apply();

        $this->collection->apply();
    }
}
