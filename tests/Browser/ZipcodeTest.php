<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ZipcodeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateZipcode()
    {
        $admin = \App\User::find(1);
        $zipcode = factory('App\Zipcode')->make();

        $this->browse(function (Browser $browser) use ($admin, $zipcode) {
            $browser->loginAs($admin)
                ->visit(route('admin.zipcodes.index'))
                ->clickLink('Add new')
                ->type('zipcode', $zipcode->zipcode)
                ->select('clinic_id', $zipcode->clinic_id)
                ->select('location_id', $zipcode->location_id)
                ->press('Save')
                ->assertRouteIs('admin.zipcodes.index')
                ->assertSeeIn("tr:last-child td[field-key='zipcode']", $zipcode->zipcode)
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $zipcode->clinic->nickname)
                ->assertSeeIn("tr:last-child td[field-key='location']", $zipcode->location->nickname);
        });
    }

    public function testEditZipcode()
    {
        $admin = \App\User::find(1);
        $zipcode = factory('App\Zipcode')->create();
        $zipcode2 = factory('App\Zipcode')->make();

        $this->browse(function (Browser $browser) use ($admin, $zipcode, $zipcode2) {
            $browser->loginAs($admin)
                ->visit(route('admin.zipcodes.index'))
                ->click('tr[data-entry-id="'.$zipcode->id.'"] .btn-info')
                ->type('zipcode', $zipcode2->zipcode)
                ->select('clinic_id', $zipcode2->clinic_id)
                ->select('location_id', $zipcode2->location_id)
                ->press('Update')
                ->assertRouteIs('admin.zipcodes.index')
                ->assertSeeIn("tr:last-child td[field-key='zipcode']", $zipcode2->zipcode)
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $zipcode2->clinic->nickname)
                ->assertSeeIn("tr:last-child td[field-key='location']", $zipcode2->location->nickname);
        });
    }

    public function testShowZipcode()
    {
        $admin = \App\User::find(1);
        $zipcode = factory('App\Zipcode')->create();

        $this->browse(function (Browser $browser) use ($admin, $zipcode) {
            $browser->loginAs($admin)
                ->visit(route('admin.zipcodes.index'))
                ->click('tr[data-entry-id="'.$zipcode->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='zipcode']", $zipcode->zipcode)
                ->assertSeeIn("td[field-key='clinic']", $zipcode->clinic->nickname)
                ->assertSeeIn("td[field-key='location']", $zipcode->location->nickname);
        });
    }
}
