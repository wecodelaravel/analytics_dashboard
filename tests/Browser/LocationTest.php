<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LocationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateLocation()
    {
        $admin = \App\User::find(1);
        $location = factory('App\Location')->make();

        $this->browse(function (Browser $browser) use ($admin, $location) {
            $browser->loginAs($admin)
                ->visit(route('admin.locations.index'))
                ->clickLink('Add new')
                ->select('parent_website_id', $location->parent_website_id)
                ->type('clinic_website_link', $location->clinic_website_link)
                ->select('clinic_id', $location->clinic_id)
                ->type('clinic_location_id', $location->clinic_location_id)
                ->type('nickname', $location->nickname)
                ->select('contact_person_id', $location->contact_person_id)
                ->type('address', $location->address)
                ->type('address_2', $location->address_2)
                ->type('city', $location->city)
                ->type('state', $location->state)
                ->type('location_email', $location->location_email)
                ->type('phone', $location->phone)
                ->type('phone2', $location->phone2)
                ->attach('storefront', base_path('tests/_resources/test.jpg'))
                ->type('google_map_link', $location->google_map_link)
                ->press('Save')
                ->assertRouteIs('admin.locations.index')
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $location->clinic->nickname)
                ->assertSeeIn("tr:last-child td[field-key='clinic_location_id']", $location->clinic_location_id)
                ->assertSeeIn("tr:last-child td[field-key='nickname']", $location->nickname)
                ->assertSeeIn("tr:last-child td[field-key='contact_person']", $location->contact_person->first_name)
                ->assertSeeIn("tr:last-child td[field-key='city']", $location->city)
                ->assertSeeIn("tr:last-child td[field-key='state']", $location->state)
                ->assertSeeIn("tr:last-child td[field-key='phone']", $location->phone);
        });
    }

    public function testEditLocation()
    {
        $admin = \App\User::find(1);
        $location = factory('App\Location')->create();
        $location2 = factory('App\Location')->make();

        $this->browse(function (Browser $browser) use ($admin, $location, $location2) {
            $browser->loginAs($admin)
                ->visit(route('admin.locations.index'))
                ->click('tr[data-entry-id="'.$location->id.'"] .btn-info')
                ->select('parent_website_id', $location2->parent_website_id)
                ->type('clinic_website_link', $location2->clinic_website_link)
                ->select('clinic_id', $location2->clinic_id)
                ->type('clinic_location_id', $location2->clinic_location_id)
                ->type('nickname', $location2->nickname)
                ->select('contact_person_id', $location2->contact_person_id)
                ->type('address', $location2->address)
                ->type('address_2', $location2->address_2)
                ->type('city', $location2->city)
                ->type('state', $location2->state)
                ->type('location_email', $location2->location_email)
                ->type('phone', $location2->phone)
                ->type('phone2', $location2->phone2)
                ->attach('storefront', base_path('tests/_resources/test.jpg'))
                ->type('google_map_link', $location2->google_map_link)
                ->press('Update')
                ->assertRouteIs('admin.locations.index')
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $location2->clinic->nickname)
                ->assertSeeIn("tr:last-child td[field-key='clinic_location_id']", $location2->clinic_location_id)
                ->assertSeeIn("tr:last-child td[field-key='nickname']", $location2->nickname)
                ->assertSeeIn("tr:last-child td[field-key='contact_person']", $location2->contact_person->first_name)
                ->assertSeeIn("tr:last-child td[field-key='city']", $location2->city)
                ->assertSeeIn("tr:last-child td[field-key='state']", $location2->state)
                ->assertSeeIn("tr:last-child td[field-key='phone']", $location2->phone);
        });
    }

    public function testShowLocation()
    {
        $admin = \App\User::find(1);
        $location = factory('App\Location')->create();

        $this->browse(function (Browser $browser) use ($admin, $location) {
            $browser->loginAs($admin)
                ->visit(route('admin.locations.index'))
                ->click('tr[data-entry-id="'.$location->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='parent_website']", $location->parent_website->website)
                ->assertSeeIn("td[field-key='clinic_website_link']", $location->clinic_website_link)
                ->assertSeeIn("td[field-key='clinic']", $location->clinic->nickname)
                ->assertSeeIn("td[field-key='clinic_location_id']", $location->clinic_location_id)
                ->assertSeeIn("td[field-key='nickname']", $location->nickname)
                ->assertSeeIn("td[field-key='contact_person']", $location->contact_person->first_name)
                ->assertSeeIn("td[field-key='address']", $location->address)
                ->assertSeeIn("td[field-key='address_2']", $location->address_2)
                ->assertSeeIn("td[field-key='city']", $location->city)
                ->assertSeeIn("td[field-key='state']", $location->state)
                ->assertSeeIn("td[field-key='location_email']", $location->location_email)
                ->assertSeeIn("td[field-key='phone']", $location->phone)
                ->assertSeeIn("td[field-key='phone2']", $location->phone2)
                ->assertSeeIn("td[field-key='google_map_link']", $location->google_map_link)
                ->assertSeeIn("td[field-key='created_by']", $location->created_by->name);
        });
    }
}
