<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Postman\Building;

use Playground\Make\Postman\Configuration\Collection;

/**
 * \Playground\Make\Postman\Building\BuildCollection
 */
trait BuildCollection
{
    protected Collection $collection;

    /**
     * @var array<string, array<string, string>>
     */
    protected array $tags = [];

    protected function init_postman_collection(): void
    {
        if (empty($this->collection)) {
            $this->collection = new Collection;
        }
    }

    // public function doc_add_schema($name, $path): void
    // {
    //     if (empty($this->collection['components']) || ! is_array($this->collection['components'])) {
    //         $this->collection['components'] = [];
    //     }
    //     if (empty($this->collection['components']['schemas']) || ! is_array($this->collection['components']['schemas'])) {
    //         $this->collection['components']['schemas'] = [];
    //     }
    //     $this->collection['components']['schemas'][$name] = [
    //         '$ref' => $path,
    //     ];
    // }

    public function save_postman_collection(): ?string
    {
        $this->collection->apply();

        $path_resources_packages = $this->getResourcePackageFolder();

        $filename = $this->getConfigurationFilename();

        $path = sprintf(
            '%1$s/%2$s',
            $this->getResourcePackageFolder(),
            $filename
        );

        dd([
            '__METHOD__' => __METHOD__,
            '$this->c' => $this->c,
            '$this->collection' => $this->collection,
            '$path_resources_packages' => $path_resources_packages,
            '$filename' => $filename,
            '$path' => $path,
            // '$this->controllerPackage' => $this->controllerPackage?->toArray(),
            // '$this->modelRevision' => $this->modelRevision?->toArray(),
            // '$this->modelPackage' => $this->modelPackage?->toArray(),
            // '$this->model' => $this->model?->toArray(),
        ]);

        $fullpath = $this->laravel->storagePath().$path;

        $this->path_to_configuration = $fullpath;

        $payload = json_encode($this->c->apply(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        if ($payload) {
            $this->files->put(
                $fullpath,
                $payload
            );

            $this->components->info(sprintf(
                'The postman collection [%s] was saved in [%s]',
                $filename,
                $fullpath
            ));
        }

        // return $this->yaml_write('collection.yml', $this->collection->apply()->toArray());
    }
}
