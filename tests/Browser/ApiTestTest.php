<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ApiTestTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateApiTest()
    {
        $admin = \App\User::find(1);
        $api_test = factory('App\ApiTest')->make();

        $this->browse(function (Browser $browser) use ($admin, $api_test) {
            $browser->loginAs($admin)
                ->visit(route('admin.api_tests.index'))
                ->clickLink('Add new')
                ->type('submitted', $api_test->submitted)
                ->type('name', $api_test->name)
                ->type('email', $api_test->email)
                ->type('subject', $api_test->subject)
                ->type('message', $api_test->message)
                ->type('submitted_user_city', $api_test->submitted_user_city)
                ->type('submitted_user_state', $api_test->submitted_user_state)
                ->type('searched_for', $api_test->searched_for)
                ->type('country', $api_test->country)
                ->type('latitude', $api_test->latitude)
                ->type('longitude', $api_test->longitude)
                ->press('Save')
                ->assertRouteIs('admin.api_tests.index')
                ->assertSeeIn("tr:last-child td[field-key='submitted']", $api_test->submitted)
                ->assertSeeIn("tr:last-child td[field-key='name']", $api_test->name)
                ->assertSeeIn("tr:last-child td[field-key='email']", $api_test->email)
                ->assertSeeIn("tr:last-child td[field-key='subject']", $api_test->subject)
                ->assertSeeIn("tr:last-child td[field-key='message']", $api_test->message);
        });
    }

    public function testEditApiTest()
    {
        $admin = \App\User::find(1);
        $api_test = factory('App\ApiTest')->create();
        $api_test2 = factory('App\ApiTest')->make();

        $this->browse(function (Browser $browser) use ($admin, $api_test, $api_test2) {
            $browser->loginAs($admin)
                ->visit(route('admin.api_tests.index'))
                ->click('tr[data-entry-id="'.$api_test->id.'"] .btn-info')
                ->type('submitted', $api_test2->submitted)
                ->type('name', $api_test2->name)
                ->type('email', $api_test2->email)
                ->type('subject', $api_test2->subject)
                ->type('message', $api_test2->message)
                ->type('submitted_user_city', $api_test2->submitted_user_city)
                ->type('submitted_user_state', $api_test2->submitted_user_state)
                ->type('searched_for', $api_test2->searched_for)
                ->type('country', $api_test2->country)
                ->type('latitude', $api_test2->latitude)
                ->type('longitude', $api_test2->longitude)
                ->press('Update')
                ->assertRouteIs('admin.api_tests.index')
                ->assertSeeIn("tr:last-child td[field-key='submitted']", $api_test2->submitted)
                ->assertSeeIn("tr:last-child td[field-key='name']", $api_test2->name)
                ->assertSeeIn("tr:last-child td[field-key='email']", $api_test2->email)
                ->assertSeeIn("tr:last-child td[field-key='subject']", $api_test2->subject)
                ->assertSeeIn("tr:last-child td[field-key='message']", $api_test2->message);
        });
    }

    public function testShowApiTest()
    {
        $admin = \App\User::find(1);
        $api_test = factory('App\ApiTest')->create();

        $this->browse(function (Browser $browser) use ($admin, $api_test) {
            $browser->loginAs($admin)
                ->visit(route('admin.api_tests.index'))
                ->click('tr[data-entry-id="'.$api_test->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='submitted']", $api_test->submitted)
                ->assertSeeIn("td[field-key='name']", $api_test->name)
                ->assertSeeIn("td[field-key='email']", $api_test->email)
                ->assertSeeIn("td[field-key='subject']", $api_test->subject)
                ->assertSeeIn("td[field-key='message']", $api_test->message)
                ->assertSeeIn("td[field-key='submitted_user_city']", $api_test->submitted_user_city)
                ->assertSeeIn("td[field-key='submitted_user_state']", $api_test->submitted_user_state)
                ->assertSeeIn("td[field-key='searched_for']", $api_test->searched_for)
                ->assertSeeIn("td[field-key='country']", $api_test->country)
                ->assertSeeIn("td[field-key='latitude']", $api_test->latitude)
                ->assertSeeIn("td[field-key='longitude']", $api_test->longitude);
        });
    }
}
