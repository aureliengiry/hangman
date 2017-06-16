<?php

namespace AppBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class ComposerDataCollector extends DataCollector
{
    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $lock = json_decode(file_get_contents(__DIR__.'/../../../composer.lock'), true);

        $this->data = [
            'packages_count' => count($lock['packages']),
            'packages_dev_count' => count($lock['packages-dev']),
            'packages' => array_merge($lock['packages'], $lock['packages-dev'])
        ];
    }

    public function getPackagesCount()
    {
        return $this->data['packages_count'];
    }

    public function getPackagesDevCount()
    {
        return $this->data['packages_dev_count'];
    }
    public function getPackages()
    {
        return $this->data['packages'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'composer';
    }
}
