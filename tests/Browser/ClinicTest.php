<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ClinicTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateClinic()
    {
        $admin = \App\User::find(1);
        $clinic = factory('App\Clinic')->make();

        $relations = [
            factory('App\User')->create(),
            factory('App\User')->create(),
        ];

        $this->browse(function (Browser $browser) use ($admin, $clinic, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.clinics.index'))
                ->clickLink('Add new')
                ->type('nickname', $clinic->nickname)
                ->attach('logo', base_path('tests/_resources/test.jpg'))
                ->select('company_id', $clinic->company_id)
                ->select('select[name="users[]"]', $relations[0]->id)
                ->select('select[name="users[]"]', $relations[1]->id)
                ->type('notes', $clinic->notes)
                ->press('Save')
                ->assertRouteIs('admin.clinics.index')
                ->assertSeeIn("tr:last-child td[field-key='nickname']", $clinic->nickname)
                ->assertSeeIn("tr:last-child td[field-key='company']", $clinic->company->name)
                ->assertSeeIn("tr:last-child td[field-key='users'] span:first-child", $relations[0]->name)
                ->assertSeeIn("tr:last-child td[field-key='users'] span:last-child", $relations[1]->name);
        });
    }

    public function testEditClinic()
    {
        $admin = \App\User::find(1);
        $clinic = factory('App\Clinic')->create();
        $clinic2 = factory('App\Clinic')->make();

        $relations = [
            factory('App\User')->create(),
            factory('App\User')->create(),
        ];

        $this->browse(function (Browser $browser) use ($admin, $clinic, $clinic2, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.clinics.index'))
                ->click('tr[data-entry-id="'.$clinic->id.'"] .btn-info')
                ->type('nickname', $clinic2->nickname)
                ->attach('logo', base_path('tests/_resources/test.jpg'))
                ->select('company_id', $clinic2->company_id)
                ->select('select[name="users[]"]', $relations[0]->id)
                ->select('select[name="users[]"]', $relations[1]->id)
                ->type('notes', $clinic2->notes)
                ->press('Update')
                ->assertRouteIs('admin.clinics.index')
                ->assertSeeIn("tr:last-child td[field-key='nickname']", $clinic2->nickname)
                ->assertSeeIn("tr:last-child td[field-key='company']", $clinic2->company->name)
                ->assertSeeIn("tr:last-child td[field-key='users'] span:first-child", $relations[0]->name)
                ->assertSeeIn("tr:last-child td[field-key='users'] span:last-child", $relations[1]->name);
        });
    }

    public function testShowClinic()
    {
        $admin = \App\User::find(1);
        $clinic = factory('App\Clinic')->create();

        $relations = [
            factory('App\User')->create(),
            factory('App\User')->create(),
        ];

        $clinic->users()->attach([$relations[0]->id, $relations[1]->id]);

        $this->browse(function (Browser $browser) use ($admin, $clinic, $relations) {
            $browser->loginAs($admin)
                ->visit(route('admin.clinics.index'))
                ->click('tr[data-entry-id="'.$clinic->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='nickname']", $clinic->nickname)
                ->assertSeeIn("td[field-key='company']", $clinic->company->name)
                ->assertSeeIn("tr:last-child td[field-key='users'] span:first-child", $relations[0]->name)
                ->assertSeeIn("tr:last-child td[field-key='users'] span:last-child", $relations[1]->name)
                ->assertSeeIn("td[field-key='notes']", $clinic->notes);
        });
    }
}
