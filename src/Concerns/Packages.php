<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Postman\Concerns;

use Playground\Make\Configuration\Model;
use Playground\Make\Package\Configuration\Package;

/**
 * \Playground\Make\Postman\Concerns\Packages
 */
trait Packages
{
    protected ?Model $modelRevision = null;

    protected ?Package $modelPackage = null;

    /**
     * Loads a playground-api or playground-resource package.
     */
    protected ?Package $controllerPackage = null;

    // $model_package = $this->hasOption('model-package') && is_string($this->option('model-package')) ? $this->option('model-package') : '';
    // if ($model_package) {
    //     $this->load_model_package($model_package);
    // }

    public function load_controller_package(mixed $file, bool $apply = true): void
    {
        if ($file && is_string($file)) {
            $this->controllerPackage = new Package(
                $this->readJsonFileAsArray($file, false, 'Controller Package File'),
            );
            if ($apply) {
                $this->controllerPackage->apply();
            }
        }
    }

    public function load_model_package(mixed $file, bool $apply = true): void
    {
        if ($file && is_string($file)) {
            $this->modelPackage = new Package(
                $this->readJsonFileAsArray($file, false, 'Model Package File'),
            );
            if ($apply) {
                $this->modelPackage->apply();
            }
        }
    }

    public function load_model_revision(mixed $file, bool $apply = true): void
    {
        if ($file && is_string($file)) {
            $this->modelRevision = new Model(
                $this->readJsonFileAsArray($file, false, 'Model Revision File'),
            );
            if ($apply) {
                $this->modelRevision->apply();
            }
        }
    }
    // $models = $this->modelPackage?->models() ?? [];

    // $models = $this->modelPackage?->models() ?? [];
    // foreach ($models as $model => $file) {
    //     if (is_string($file) && $file) {

    //         $model = new Model($this->readJsonFileAsArray($file));

    //         if ($model->revision()) {
    //             // Revisions are handled by the base model.
    //             continue;
    //         }

    //         // $params_controller['--model'] = $model->name();
    //         // $params_controller['name'] = Str::of($model->name())->studly()->finish('Controller')->toString();
    //         // $params_controller['--model-file'] = $file;

    //         // dump([
    //         //     '__METHOD__' => __METHOD__,
    //         //     // '$params_controller' => $params_controller,
    //         //     // '$this->c' => $this->c,
    //         //     '$model->name()' => $model->name(),
    //         //     '$model->revision()' => $model->revision(),
    //         //     // '$model' => $model,
    //         //     // '$this->c' => $this->c,
    //         // ]);
    //         $this->build_index_blade_section($model);
    //     }
    // }
}
