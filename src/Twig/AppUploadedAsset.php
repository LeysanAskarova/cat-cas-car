<?php

namespace App\Twig;

use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AppUploadedAsset implements RuntimeExtensionInterface
{
    /**
     * @var ParameterBagInterface
     */
    private $parameterBagInterface;
    /**
     * @var Packages
     */
    private $packages;
    public function __construct(ParameterBagInterface $parameterBagInterface, Packages $packages)
    {
        $this->parameterBagInterface = $parameterBagInterface;
        $this->packages = $packages;
    }

    public function asset(string $config, ?string $path)
    {
        return $this->packages->getUrl($this->parameterBagInterface->get($config).'/'.$path);
    }
}