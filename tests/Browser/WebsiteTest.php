<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WebsiteTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateWebsite()
    {
        $admin = \App\User::find(1);
        $website = factory('App\Website')->make();

        $this->browse(function (Browser $browser) use ($admin, $website) {
            $browser->loginAs($admin)
                ->visit(route('admin.websites.index'))
                ->clickLink('Add new')
                ->select('company_id', $website->company_id)
                ->select('clinic_id', $website->clinic_id)
                ->type('website', $website->website)
                ->press('Save')
                ->assertRouteIs('admin.websites.index')
                ->assertSeeIn("tr:last-child td[field-key='company']", $website->company->name)
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $website->clinic->nickname)
                ->assertSeeIn("tr:last-child td[field-key='website']", $website->website);
        });
    }

    public function testEditWebsite()
    {
        $admin = \App\User::find(1);
        $website = factory('App\Website')->create();
        $website2 = factory('App\Website')->make();

        $this->browse(function (Browser $browser) use ($admin, $website, $website2) {
            $browser->loginAs($admin)
                ->visit(route('admin.websites.index'))
                ->click('tr[data-entry-id="'.$website->id.'"] .btn-info')
                ->select('company_id', $website2->company_id)
                ->select('clinic_id', $website2->clinic_id)
                ->type('website', $website2->website)
                ->press('Update')
                ->assertRouteIs('admin.websites.index')
                ->assertSeeIn("tr:last-child td[field-key='company']", $website2->company->name)
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $website2->clinic->nickname)
                ->assertSeeIn("tr:last-child td[field-key='website']", $website2->website);
        });
    }

    public function testShowWebsite()
    {
        $admin = \App\User::find(1);
        $website = factory('App\Website')->create();

        $this->browse(function (Browser $browser) use ($admin, $website) {
            $browser->loginAs($admin)
                ->visit(route('admin.websites.index'))
                ->click('tr[data-entry-id="'.$website->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='company']", $website->company->name)
                ->assertSeeIn("td[field-key='clinic']", $website->clinic->nickname)
                ->assertSeeIn("td[field-key='website']", $website->website);
        });
    }
}
