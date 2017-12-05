<?php

namespace Autowp\ZFComponents;

class Module
{
    public function getConfig(): array
    {
        $provider = new ConfigProvider();
        return [
            'filters'         => $provider->getFilterConfig(),
            'gulp-rev'        => $provider->getGulpRevConfig(),
            'view_helpers'    => $provider->getViewHelperConfig(),
            'service_manager' => $provider->getDependencyConfig(),
            'tables'          => [],
            'rollbar'         => $provider->getRollbarConfig()
        ];
    }
}
