<?php

namespace Test\Filmoteca\StaticPages\Models;

use Filmoteca\StaticPages\Models\StaticPage\Eloquent\StaticPage;
use Illuminate\Support\Str;
use \Mockery as m;

class StaticPageTest extends \PHPUnit_Framework_TestCase
{
    public function testHasParent()
    {
        $staticPage = new StaticPage();
        $staticPage->parent_page_id = 1;

        $staticPageWithoutParent = new StaticPage();

        $this->assertTrue($staticPage->hasParent());
        $this->assertNotTrue($staticPageWithoutParent->hasParent());
    }

    /**
     * @throws \Filmoteca\StaticPages\Models\InvalidArgumentException
     * @expectedException     \InvalidArgumentException
     */
    public function testSetStatus()
    {
        $staticPage = new StaticPage();

        foreach (StaticPage::getAvailableStatus() as $status) {
            $staticPage->setStatus($status);
            $this->assertEquals($status, $staticPage->getStatus());
        }

        $staticPage->setStatus('status-invalid');
    }
}
