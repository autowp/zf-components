<?php

namespace Autowp\ZFComponents;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Mail\Transport\TransportInterface;

class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'gulp-rev'     => $this->getGulpRevConfig(),
            'filters'      => $this->getFilterConfig(),
            'view_helpers' => $this->getViewHelperConfig(),
            'tables'       => []
        ];
    }

    /**
     * Return application-level dependency configuration.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'aliases' => [
                'TableManager' => Db\TableManager::class
            ],
            'factories' => [
                GulpRev::class            => Factory\GulpRevFactory::class,
                TransportInterface::class => Mail\Transport\TransportServiceFactory::class,
                Db\TableManager::class    => Db\TableManagerFactory::class
            ]
        ];
    }

    /**
     * @return array
     */
    public function getGulpRevConfig()
    {
        return [
            'manifests' => []
        ];
    }

    /**
     * Return zend-filter configuration.
     *
     * @return array
     */
    public function getFilterConfig()
    {
        return [
            'aliases' => [
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

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'aliases' => [
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
