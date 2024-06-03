<?php

namespace Rochmadnf\Recail;

use Rochmadnf\Recail\Exceptions\DirectoryNullException;
use Rochmadnf\Recail\Exceptions\NodeNotFoundException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class Renderer extends Process
{
    /**
     * @throws NodeNotFoundException
     */
    private function __construct(string $view, array $data = [])
    {
        parent::__construct([
            $this->resolveNodeExecutable(),
            base_path(config('react-email.tsx_path') ?? '/node_modules/.bin/tsx'),
            __DIR__.'/../render.tsx',
            $this->resolveDirectoryPath().$view,
            json_encode($data),
        ], base_path());
    }

    /**
     * Calls the react-email render
     *
     * @param  string  $view  name of the file the component is in
     * @param  array  $data  data that will be passed as props to the component
     */
    public static function render(string $view, array $data): array
    {
        $process = new self($view, $data);

        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return json_decode($process->getOutput(), true);
    }

    /**
     * Resolve the node path from the configuration or executable finder.
     *
     * @throws NodeNotFoundException
     */
    public static function resolveNodeExecutable(): string
    {
        if ($executable = config('react-email.node_path') ?? app(ExecutableFinder::class)->find('node')) {
            return $executable;
        }

        throw new NodeNotFoundException(
            'Unable to resolve node path automatically, please provide a configuration value in react-emails'
        );
    }

    /**
     * Resolve the directory path.
     *
     * @throws DirectoryNullException
     */
    public static function resolveDirectoryPath(): string
    {
        if (! is_null($dirPath = config('react-email.template_directory'))) {
            return $dirPath;
        }

        throw new DirectoryNullException(
            'Unable to resolve template directory path, please provide a configuration value in react-emails'
        );
    }
}
