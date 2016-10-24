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
            'service_manager' => $provider->getDependencyConfig(),
            'view_helpers'    => $provider->getViewHelperConfig(),
            'gulp-rev'        => $provider->getGulpRevConfig()
        ];
    }
}
