<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class LivewireCustomCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud
    {nameOfTheClass? : The name of the class.}, {nameOfTheModelClass? : The name of the model class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Our custom class properties here!
     */
    protected $nameOfTheClass;
    protected $nameOfTheModelClass;
    protected $file;

    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->gatherParameters();
        $this->generateLivewireCrudClassFile();
        $this->generateLivewireCrudViewFile();
    }

    /**
     * Gather all necessary parameters
     *
     * @return void
     */
    protected function gatherParameters()
    {
        $this->nameOfTheClass = $this->argument('nameOfTheClass');
        $this->nameOfTheModelClass = $this->argument('nameOfTheModelClass');

        if (!$this->nameOfTheClass) {
            $this->nameOfTheClass = $this->ask('Enter class name');
        }

        if (!$this->nameOfTheModelClass) {
            $this->nameOfTheModelClass = $this->ask('Enter model name');
        }

        $this->nameOfTheClass = Str::studly($this->nameOfTheClass);
        $this->nameOfTheModelClass = Str::studly($this->nameOfTheModelClass);

        $this->info($this->nameOfTheClass.' '.$this->nameOfTheModelClass);

    }

    /**
     * Generate the CRUD class file.
     *
     * @return void|bool
     * @throws FileNotFoundException
     */
    protected function generateLivewireCrudClassFile()
    {
        $fileOrigin = base_path('/stubs/custom.livewire.crud.stub');
        $fileDestination = base_path('/app/Http/Livewire/'.$this->nameOfTheClass.'.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This class file already exists: '.$this->nameOfTheClass.'.php');
            $this->info('Aborting livewire class file creation.');

            return false;
        }

        $fileOriginalString = $this->file->get($fileOrigin);

        $replaceFileOriginalString = Str::replaceArray('{{}}', [
            $this->nameOfTheModelClass,
            $this->nameOfTheClass,
            $this->nameOfTheModelClass,
            $this->nameOfTheModelClass,
            $this->nameOfTheModelClass,
            $this->nameOfTheModelClass,
            $this->nameOfTheModelClass,
            $this->nameOfTheModelClass,
            $this->nameOfTheModelClass,
            Str::kebab($this->nameOfTheClass),
        ],
            $fileOriginalString
        );

        $this->file->put($fileDestination, $replaceFileOriginalString);
        $this->info('Livewire class file created: '. $fileDestination);
    }

    protected function generateLivewireCrudViewFile()
    {
        $fileOrigin = base_path('/stubs/custom.livewire.crud.view.stub');
        $fileDestination = base_path('/resources/views/livewire/'.Str::kebab($this->nameOfTheClass).'.blade.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This view file already exists: '.Str::kebab($this->nameOfTheClass).'.blade.php');
            $this->info('Aborting view file creation.');

            return false;
        }

        $this->file->copy($fileOrigin, $fileDestination);
        $this->info('Livewire class file created: '. $fileDestination);
    }
}
