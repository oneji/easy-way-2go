<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class CreateScopeClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:scope {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create scope class';

    /**
     * Filesystem instance
     * 
     * @var string
     */
    protected $filesystem;

    /**
     * Default folder
     * 
     * @var string
     */
    protected $folder = 'App\Http\Scopes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FileSystem $filesystem)
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
        // Get the form request class name
        $this->requestName = $this->argument('name');
        
        // Check if the folder exists
        if(!File::exists($this->folder)) {
            File::makeDirectory($this->folder);
        }

        // Check if the scope class already created
        if ($this->filesystem->exists(app_path("Scopes/{$this->requestName}.php"))){
            return $this->error('The given scope class already exists!');
        }

        $this->createFile(
            app_path('Console/Stubs/DummyScope.stub'),
            app_path("Scopes/{$this->requestName}.php")
        );

        $this->info('Scope class ' . $this->requestName . ' created.');
    }

    /**
     * Create scope file file
     * 
     * @param  string $dummySource
     * @param  string $destinationPath
     * @return void
     */
    protected function createFile($dummySource, $destinationPath)
    {
        $dummyScope = $this->filesystem->get($dummySource);
        $scopeContent = str_replace('DummyScope', $this->requestName, $dummyScope);
        $this->filesystem->put($dummySource, $scopeContent);
        $this->filesystem->copy($dummySource, $destinationPath);
        $this->filesystem->put($dummySource, $dummyScope);
    }
}
