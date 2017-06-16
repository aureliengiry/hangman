<?php

namespace AppBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AppExtension extends \Twig_Extension
{
    const ALT_LOCALES = [
        'fr' => 'en',
        'en' => 'fr',
    ];

    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('alt_path', [$this, 'generateAltPath'])
        ];
    }

    public function generateAltPath($currentRouteName, $altLocale, array $params = [])
    {
        $params['_locale'] = self::ALT_LOCALES[$altLocale];

        return $this->urlGenerator->generate($currentRouteName, $params);
    }
}
