<?php

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\GulpRev;

/**
 * @group Autowp_ExternalLoginService
 */
class GulpRevTest extends \PHPUnit_Framework_TestCase
{
    
    
    public function testNotFailsOnMissingManifest()
    {
        $service = new GulpRev([
            'manifest' => 'not-existent-file.json',
            'prefix'   => '/'
        ]);
    
        $result = $service->getRevUrl('test.css');
    }

    public function testPrefixPrepends()
    {
        $service = new GulpRev([
            'manifest' => 'not-existent-file.json',
            'prefix'   => 'http://prefix/'
        ]);
    
        $result = $service->getRevUrl('test.css');
    
        $this->assertEquals($result, 'http://prefix/test.css');
    }
}