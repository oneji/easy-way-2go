<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateTraitClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create a basic trait class';

    /**
     * Filesystem instance
     * 
     * @var string
     */
    protected $filesystem;

    /**
     * Default laracom folder
     * 
     * @var string
     */
    protected $folder;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the service name
        $this->traitName = $this->argument('name');

        // Check if the service class already created
        if ($this->filesystem->exists(app_path("Http/Traits/{$this->traitName}.php"))){
            return $this->error('The given service already exists!');
        }

        $this->createFile(
            app_path('Console/Stubs/DummyTrait.stub'),
            app_path("Http/Traits/{$this->traitName}.php")
        );

        $this->info('Trait class ' . $this->traitName . ' created.');
    }

    /**
     * Create service class file
     * 
     * @param  string $dummy        
     * @param  string $destinationPath
     * @return void
     */
    protected function createFile($dummySource, $destinationPath)
    {
        $dummyTrait = $this->filesystem->get($dummySource);
        $serviceContent = str_replace('DummyTrait', $this->traitName, $dummyTrait);
        $this->filesystem->put($dummySource, $serviceContent);
        $this->filesystem->copy($dummySource, $destinationPath);
        $this->filesystem->put($dummySource, $dummyTrait);
    }
}
