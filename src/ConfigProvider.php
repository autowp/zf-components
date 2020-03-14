<?php

declare(strict_types=1);

namespace Autowp\ZFComponents;

use Laminas\Mail\Transport\TransportInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'gulp-rev'     => $this->getGulpRevConfig(),
            'filters'      => $this->getFilterConfig(),
            'view_helpers' => $this->getViewHelperConfig(),
            'tables'       => [],
        ];
    }

    /**
     * Return application-level dependency configuration.
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases'   => [
                'TableManager' => Db\TableManager::class,
            ],
            'factories' => [
                GulpRev::class            => Factory\GulpRevFactory::class,
                TransportInterface::class => Mail\Transport\TransportServiceFactory::class,
                Db\TableManager::class    => Db\TableManagerFactory::class,
            ],
        ];
    }

    public function getGulpRevConfig(): array
    {
        return [
            'manifests' => [],
        ];
    }

    /**
     * Return zend-filter configuration.
     */
    public function getFilterConfig(): array
    {
        return [
            'aliases'   => [
                'singlespaces'    => Filter\SingleSpaces::class,
                'singleSpaces'    => Filter\SingleSpaces::class,
                'SingleSpaces'    => Filter\SingleSpaces::class,
                'transliteration' => Filter\Transliteration::class,
                'Transliteration' => Filter\Transliteration::class,
                'filenamesafe'    => Filter\FilenameSafe::class,
                'filenameSafe'    => Filter\FilenameSafe::class,
                'FilenameSafe'    => Filter\FilenameSafe::class,
            ],
            'factories' => [
                Filter\SingleSpaces::class    => InvokableFactory::class,
                Filter\Transliteration::class => InvokableFactory::class,
                Filter\FilenameSafe::class    => InvokableFactory::class,
            ],
        ];
    }

    public function getViewHelperConfig(): array
    {
        return [
            'aliases'   => [
                'htmla'     => View\Helper\HtmlA::class,
                'htmlA'     => View\Helper\HtmlA::class,
                'HtmlA'     => View\Helper\HtmlA::class,
                'htmlimg'   => View\Helper\HtmlImg::class,
                'htmlImg'   => View\Helper\HtmlImg::class,
                'HtmlImg'   => View\Helper\HtmlImg::class,
                'humanTime' => View\Helper\HumanTime::class,
                'HumanTime' => View\Helper\HumanTime::class,
                'humanDate' => View\Helper\HumanDate::class,
                'HumanDate' => View\Helper\HumanDate::class,
                'gulprev'   => View\Helper\GulpRev::class,
                'gulpRev'   => View\Helper\GulpRev::class,
                'GulpRev'   => View\Helper\GulpRev::class,
            ],
            'factories' => [
                View\Helper\HtmlA::class     => InvokableFactory::class,
                View\Helper\HtmlImg::class   => InvokableFactory::class,
                View\Helper\HumanTime::class => InvokableFactory::class,
                View\Helper\HumanDate::class => InvokableFactory::class,
                View\Helper\GulpRev::class   => Factory\GulpRevViewHelperFactory::class,
            ],
        ];
    }
}
