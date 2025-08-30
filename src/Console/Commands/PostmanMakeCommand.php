<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Make\Postman\Console\Commands;

use Illuminate\Support\Str;
use Playground\Make\Building\Concerns;
use Playground\Make\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Make\Configuration\Model;
use Playground\Make\Console\Commands\GeneratorCommand;
use Playground\Make\Postman\Building;
use Playground\Make\Postman\Concerns\Packages;
use Playground\Make\Postman\Configuration\Postman as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function Laravel\Prompts\multiselect;

/**
 * \Playground\Make\Postman\Console\Commands\PostmanMakeCommand
 */
#[AsCommand(name: 'playground:make:postman')]
class PostmanMakeCommand extends GeneratorCommand
{
    // use Building\BuildModel;
    // use Building\BuildModelColumns;
    // use Building\BuildRequest;
    // use Building\BuildServers;
    use Building\BuildCollection;

    // use Building\BuildController;
    // use Building\BuildControllerForm;
    // use Building\BuildControllerId;
    // use Building\BuildControllerIndex;
    // use Building\BuildControllerLock;
    // use Building\BuildControllerRestore;
    // use Building\BuildControllerRevision;
    // use Building\BuildControllerRevisions;
    // use Building\BuildExternalDocs;
    use Building\BuildInfo;
    use Concerns\BuildImplements;
    use Concerns\BuildUses;
    use Packages;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    const SEARCH = [
        'docs' => '',
        // 'base_docs' => 'welcome',
        'extends' => '',
        'class' => '',
        'controller' => '',
        'folder' => '',
        'namespace' => '',
        'organization' => '',
        // 'namespacedModel' => '',
        // 'NamespacedDummyUserModel' => '',
        // 'namespacedUserModel' => '',
        // 'user' => '',
        // 'model' => '',
        // 'modelVariable' => '',
        // 'model_column' => '',
        // 'model_label' => '',
        // 'model_slug_plural' => '',
        'module' => '',
        'module_slug' => '',
        'title' => '',
        'package' => '',
        'config' => '',
        // 'docs_prefix' => '',
    ];

    protected string $path_destination_folder = '';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:postman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a postman collection';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Postman';

    protected bool $isApi = false;

    protected bool $isResource = false;

    protected bool $replace = false;

    public function prepareOptions(): void
    {
        $this->modelRevision = null;

        $options = $this->options();
        $setOptions = [];
        // if ($this->hasOption('playground') && $this->option('playground')) {
        //     $this->c->setOptions([
        //         'playground' => true,
        //     ]);
        // }

        $type = $this->getConfigurationType();

        if (in_array($type, [
            'resource',
            'playground-resource',
        ])) {
            $this->isApi = false;
            $this->isResource = true;
            $setOptions['withAuthSanctum'] = true;
            $setOptions['withAuthSession'] = true;
        } elseif (in_array($type, [
            'api',
            'playground-api',
        ])) {
            $this->isApi = true;
            $this->isResource = false;
            $setOptions['withAuthSanctum'] = true;
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$this->route_prefix' => $this->route_prefix,
        //     '$this->isApi' => $this->isApi,
        //     '$this->isResource' => $this->isResource,
        //     '$this->c->type()' => $this->c->type(),
        //     '$this->options()' => $this->options(),
        // ]);

        $model_file = $this->hasOption('model-file') ? $this->option('model-file') : $this->c->model_file();
        $model_revision_file = $this->hasOption('model-revision-file') ? $this->option('model-revision-file') : $this->c->model_revision_file();
        $model_package = $this->hasOption('model-package') ? $this->option('model-package') : $this->c->model_package();
        $controller_package = $this->hasOption('controller-package') ? $this->option('controller-package') : $this->c->controller_package();

        $this->initModel($this->c->skeleton());

        // if ($model_file && is_string($model_file)) {
        //     $setOptions['model_file'] = $model_file;
        // }

        if ($model_revision_file && is_string($model_revision_file)) {
            $this->load_model_revision($model_revision_file);
            // $setOptions['model_revision_file'] = $model_revision_file;
        }

        if ($model_package && is_string($model_package)) {
            $this->load_model_package($model_package);
            $setOptions['model_package'] = $model_package;
            $setOptions['models'] = $this->modelPackage->models();
        }

        if ($controller_package && is_string($controller_package)) {

            $this->load_controller_package($controller_package);
            $setOptions['controller_package'] = $controller_package;

            $setOptions['config'] = $this->controllerPackage->config();
            $setOptions['module'] = $this->controllerPackage->module();
            $setOptions['module_slug'] = $this->controllerPackage->module_slug();
            $setOptions['name'] = $this->controllerPackage->package_name();
            $setOptions['description'] = $this->controllerPackage->package_description();
            $setOptions['namespace'] = $this->controllerPackage->namespace();
            $setOptions['organization'] = $this->controllerPackage->organization();
            $setOptions['package'] = $this->controllerPackage->package();
        }

        if ($setOptions) {
            $this->c->setOptions($setOptions)->apply();
        }

        $this->saveConfiguration();

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->options()' => $this->options(),
        //     '$this->c' => $this->c,
        //     // '$this->model' => $this->model?->toArray(),
        //     // '$this->modelRevision' => $this->modelRevision?->toArray(),
        //     // '$this->c' => $this->c->toArray(),
        //     // '$this->searches' => $this->searches,
        //     '$this->controllerPackage' => $this->controllerPackage?->toArray(),
        //     '$setOptions' => $setOptions,
        // ]);
    }

    /**
     * Execute the console command.
     *
     * Types:
     * - model
     * - controller
     * - info
     * - request
     * - response
     * - security
     * - externalDocs
     * - servers
     * - paths
     * - component: securitySchemes, parameters, responses, schemas
     * - tags
     */
    public function handle()
    {
        $this->reset();

        $name = $this->getNameInput();

        $type = $this->getConfigurationType();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        // ]);

        if (in_array($type, [
            'playground-api',
            'playground-resource',
        ])) {

            $this->init_postman_collection();

            $this->build_collection_info();
            // $this->doc_external_docs();
            // $this->doc_servers();
            // $this->doc_model();
            // $this->doc_model_revision();

            // $this->doc_controller();

            $this->save_postman_collection();

        } elseif ($type === 'playground-model') {

            if (empty($this->model?->create())) {
                $this->components->error('Provide a [--model-file] with a [create] section.');
                $this->return_status = true;

                return $this->return_status;
            }

            $this->init_postman_collection();

            // $this->doc_model();
            // $this->doc_model_revision();

            $this->save_postman_collection();
        }

        $this->saveConfiguration();

        return $this->return_status;
    }

    // public function finish(): ?bool
    // {
    //     $this->saveConfiguration();

    //     // if ($this->c->test()) {
    //     //     $this->createTest();
    //     // }

    //     // if ($this->c->transformers()) {
    //     //     $this->createTransformers();
    //     // }

    //     // $this->saveConfiguration();
    //     dd([
    //         '__METHOD__' => __METHOD__,
    //         '$this->c' => $this->c,
    //         // '$this->c' => $this->c->toArray(),
    //         '$this->searches' => $this->searches,
    //         // '$this->analyze' => $this->analyze,
    //     ]);

    //     return $this->return_status;
    // }

    // /**
    //  * Build the class with the given name.
    //  *
    //  * @param  string  $name
    //  *
    //  * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
    //  */
    // protected function buildClass($name): string
    // {
    //     // if (in_array($this->c->type(), [
    //     //     'abstract',
    //     //     'model',
    //     //     'morph-pivot',
    //     //     'pivot',
    //     //     'playground-abstract',
    //     //     'playground',
    //     // ])) {
    //     $this->searches['use'] = '';
    //     $this->searches['use_class'] = '';

    //     $this->buildClass_model_table();

    //     if ($this->c->skeleton()) {
    //         $this->buildClass_skeleton();
    //     }

    //     $this->buildClass_docblock();
    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$this->c' => $this->c,
    //     //     '$this->c' => $this->c->toArray(),
    //     //     '$this->searches' => $this->searches,
    //     //     '$this->analyze' => $this->analyze,
    //     // ]);
    //     $this->buildClass_implements();
    //     $this->buildClass_table_property();
    //     $this->buildClass_perPage();
    //     $this->c->apply();

    //     $this->buildClass_attributes();
    //     $this->buildClass_fillable();
    //     $this->buildClass_casts();

    //     // // Relationships
    //     $this->buildClass_HasOne();
    //     $this->buildClass_HasMany();

    //     $this->buildClass_uses($name);

    //     // $this->c->apply();
    //     $this->applyConfigurationToSearch(true);

    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     //     // '$this->c' => $this->c,
    //     //     '$this->searches' => $this->searches,
    //     //     '$this->c->skeleton()' => $this->c->skeleton(),
    //     // ]);

    //     return parent::buildClass($name);
    // }

    protected function getStub(): string
    {
        return sprintf(
            'postman-%1$s.json',
            Str::of($this->c->package())->kebab(),
        );
    }

    // /**
    //  * Resolve the fully-qualified path to the stub.
    //  *
    //  * @param  string  $stub
    //  * @return string
    //  */
    // protected function resolveStubPath($stub)
    // {
    //     return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
    //                     ? $customPath
    //                     : __DIR__.$stub;
    // }

    // /**
    //  * Get the default namespace for the class.
    //  *
    //  * @param  string  $rootNamespace
    //  * @return string
    //  */
    // protected function getDefaultNamespace($rootNamespace)
    // {
    //     return Str::of(
    //         $this->parseClassInput($rootNamespace)
    //     )->finish('\\')->finish('Models')->toString();
    // }

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        'playground-api',
        'playground-resource',
        'playground-model',
    ];

    /**
     * Get the console command options.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['title', null, InputOption::VALUE_OPTIONAL, 'The title of the docs'];
        $options[] = ['model-package', null, InputOption::VALUE_OPTIONAL, 'The model package file for all the end points.'];
        $options[] = ['model-file', null, InputOption::VALUE_OPTIONAL, 'The model file for the controller end points.'];
        $options[] = ['model-revision-file', null, InputOption::VALUE_OPTIONAL, 'The file for the revision model.'];
        $options[] = ['controller-package', null, InputOption::VALUE_OPTIONAL, 'The controller package file for the collection.'];

        return $options;
    }

    // /**
    //  * Interact further with the user if they were prompted for missing arguments.
    //  *
    //  * @return void
    //  */
    // protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    // {
    //     $name = $this->getNameInput();
    //     if (($name && $this->isReservedName($name)) || $this->didReceiveOptions($input)) {
    //         return;
    //     }

    //     collect(multiselect('Would you like any of the following?', [
    //         'seed' => 'Database Seeder',
    //         'factory' => 'Factory',
    //         'requests' => 'Form Requests',
    //         'migration' => 'Migration',
    //         'policy' => 'Policy',
    //         'resource' => 'Resource Controller',
    //     ]))->each(fn ($option) => $input->setOption(is_string($option) ? $option : '', true));
    // }

    // /**
    //  * Create the matching test case if requested.
    //  *
    //  * @param  string  $path
    //  * @return bool
    //  */
    // protected function handleTestCreation($path)
    // {
    //     if (! $this->option('test') && ! $this->option('pest') && ! $this->option('phpunit')) {
    //         return false;
    //     }
    //     // dd([
    //     //     '__METHOD__' => __METHOD__,
    //     // ]);

    //     // $this->createTest();

    //     return true;
    // }

    protected function getConfigurationFilename(): string
    {
        // $type = $this->getConfigurationType();

        // if ($type === 'api') {
        return 'postman.json';
        // }

        // postman-playground-cms-resource.json

        // return sprintf(
        //     'postman-%1$s.json',
        //     Str::of($this->c->package())->kebab(),
        // );
    }
}
