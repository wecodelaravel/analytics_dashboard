<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AnalyticTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateAnalytic()
    {
        $admin = \App\User::find(1);
        $analytic = factory('App\Analytic')->make();

        $this->browse(function (Browser $browser) use ($admin, $analytic) {
            $browser->loginAs($admin)
                ->visit(route('admin.analytics.index'))
                ->clickLink('Add new')
                ->type('view_name', $analytic->view_name)
                ->type('view_id', $analytic->view_id)
                ->select('website_id', $analytic->website_id)
                ->press('Save')
                ->assertRouteIs('admin.analytics.index')
                ->assertSeeIn("tr:last-child td[field-key='view_name']", $analytic->view_name)
                ->assertSeeIn("tr:last-child td[field-key='view_id']", $analytic->view_id)
                ->assertSeeIn("tr:last-child td[field-key='website']", $analytic->website->website);
        });
    }

    public function testEditAnalytic()
    {
        $admin = \App\User::find(1);
        $analytic = factory('App\Analytic')->create();
        $analytic2 = factory('App\Analytic')->make();

        $this->browse(function (Browser $browser) use ($admin, $analytic, $analytic2) {
            $browser->loginAs($admin)
                ->visit(route('admin.analytics.index'))
                ->click('tr[data-entry-id="'.$analytic->id.'"] .btn-info')
                ->type('view_name', $analytic2->view_name)
                ->type('view_id', $analytic2->view_id)
                ->select('website_id', $analytic2->website_id)
                ->press('Update')
                ->assertRouteIs('admin.analytics.index')
                ->assertSeeIn("tr:last-child td[field-key='view_name']", $analytic2->view_name)
                ->assertSeeIn("tr:last-child td[field-key='view_id']", $analytic2->view_id)
                ->assertSeeIn("tr:last-child td[field-key='website']", $analytic2->website->website);
        });
    }

    public function testShowAnalytic()
    {
        $admin = \App\User::find(1);
        $analytic = factory('App\Analytic')->create();

        $this->browse(function (Browser $browser) use ($admin, $analytic) {
            $browser->loginAs($admin)
                ->visit(route('admin.analytics.index'))
                ->click('tr[data-entry-id="'.$analytic->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='view_name']", $analytic->view_name)
                ->assertSeeIn("td[field-key='view_id']", $analytic->view_id)
                ->assertSeeIn("td[field-key='website']", $analytic->website->website);
        });
    }
}
