<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContactCompanyTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateContactCompany()
    {
        $admin = \App\User::find(1);
        $contact_company = factory('App\ContactCompany')->make();

        $this->browse(function (Browser $browser) use ($admin, $contact_company) {
            $browser->loginAs($admin)
                ->visit(route('admin.contact_companies.index'))
                ->clickLink('Add new')
                ->type('name', $contact_company->name)
                ->attach('logo', base_path('tests/_resources/test.jpg'))
                ->press('Save')
                ->assertRouteIs('admin.contact_companies.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $contact_company->name);
        });
    }

    public function testEditContactCompany()
    {
        $admin = \App\User::find(1);
        $contact_company = factory('App\ContactCompany')->create();
        $contact_company2 = factory('App\ContactCompany')->make();

        $this->browse(function (Browser $browser) use ($admin, $contact_company, $contact_company2) {
            $browser->loginAs($admin)
                ->visit(route('admin.contact_companies.index'))
                ->click('tr[data-entry-id="'.$contact_company->id.'"] .btn-info')
                ->type('name', $contact_company2->name)
                ->attach('logo', base_path('tests/_resources/test.jpg'))
                ->press('Update')
                ->assertRouteIs('admin.contact_companies.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $contact_company2->name);
        });
    }

    public function testShowContactCompany()
    {
        $admin = \App\User::find(1);
        $contact_company = factory('App\ContactCompany')->create();

        $this->browse(function (Browser $browser) use ($admin, $contact_company) {
            $browser->loginAs($admin)
                ->visit(route('admin.contact_companies.index'))
                ->click('tr[data-entry-id="'.$contact_company->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $contact_company->name);
        });
    }
}
