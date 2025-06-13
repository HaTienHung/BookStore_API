<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MakeRepository extends GeneratorCommand
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:Repository {name}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Khởi tạo Repository.';

  protected $type = 'Repository';

  protected function getStub()
  {
    return base_path('stubs/repository.stub');
  }

  protected function getDefaultNamespace($rootNamespace)
  {
    $class = $this->getNameInput();
    $modifiedClassName = str_replace("Repository", "", $class);

    return $rootNamespace . "\Repositories\\" . $modifiedClassName;
  }

  protected function replaceClass($stub, $name)
  {
    $class = $this->getNameInput();
    $modifiedClassName = str_replace("Repository", "", $class);
    $variable = strtolower($modifiedClassName);

    // Do string replacement
    return str_replace([
      '{{name}}',
      '{{variable}}',
      '{{class}}',
    ], [
      $modifiedClassName,
      $variable,
      $class,
    ], $stub);
  }
}
