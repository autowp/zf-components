<?php

namespace Autowp\ZFComponents;

class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        $provider = new ConfigProvider();
        return [
            'filters'         => $provider->getFilterConfig(),
            'gulp-rev'        => $provider->getGulpRevConfig(),
            'view_helpers'    => $provider->getViewHelperConfig(),
            'service_manager' => $provider->getDependencyConfig(),
            'tables'          => []
        ];
    }
}
