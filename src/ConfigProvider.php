<?php

namespace Autowp\ZFComponents;

use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'view_helpers' => $this->getViewHelperConfig(),
            'gulp-rev'     => $this->getGulpRevConfig()
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
            'factories' => [
                GulpRev::class => Factory\GulpRevFactory::class
            ]
        ];
    }
    
    /**
     * @return array
     */
    public function getGulpRevConfig()
    {
        return [
            'manifest' => null,
            'prefix'   => '/'
        ];
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'aliases' => [
                'htmla' => View\Helper\HtmlA::class,
                'htmlA' => View\Helper\HtmlA::class,
                'HtmlA' => View\Helper\HtmlA::class,
                'htmlimg' => View\Helper\HtmlImg::class,
                'htmlImg' => View\Helper\HtmlImg::class,
                'HtmlImg' => View\Helper\HtmlImg::class,
                'gulprev' => View\Helper\GulpRev::class,
                'gulpRev' => View\Helper\GulpRev::class,
                'GulpRev' => View\Helper\GulpRev::class,
            ],
            'factories' => [
                View\Helper\HtmlA::class   => InvokableFactory::class,
                View\Helper\HtmlImg::class => InvokableFactory::class,
                View\Helper\GulpRev::class => Factory\GulpRevViewHelperFactory::class,
            ],
        ];
    }
}
