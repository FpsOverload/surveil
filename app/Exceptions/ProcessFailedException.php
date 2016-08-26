<?php

namespace App\Exceptions;

use Symfony\Component\Process\Process;

class ProcessFailedException extends \Exception {

    private $process;
    
    public function __construct(Process $process)
    {
        $error = sprintf("The command \"%s\" failed.\nError: %s (%s)",
            $process->getCommandLine(),
            $process->getExitCode(),
            $process->getExitCodeText()
        );

        parent::__construct($error);

        $this->process = $process;
    }

}
