<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdwordTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateAdword()
    {
        $admin = \App\User::find(1);
        $adword = factory('App\Adword')->make();

        $this->browse(function (Browser $browser) use ($admin, $adword) {
            $browser->loginAs($admin)
                ->visit(route('admin.adwords.index'))
                ->clickLink('Add new')
                ->select('company_id', $adword->company_id)
                ->select('website_id', $adword->website_id)
                ->type('client_customer_id', $adword->client_customer_id)
                ->type('user_agent', $adword->user_agent)
                ->type('client_id', $adword->client_id)
                ->type('client_secret', $adword->client_secret)
                ->type('refresh_token', $adword->refresh_token)
                ->type('authorization_uri', $adword->authorization_uri)
                ->type('redirect_uri', $adword->redirect_uri)
                ->type('token_credential_uri', $adword->token_credential_uri)
                ->type('scope', $adword->scope)
                ->select('clinic_id', $adword->clinic_id)
                ->press('Save')
                ->assertRouteIs('admin.adwords.index')
                ->assertSeeIn("tr:last-child td[field-key='company']", $adword->company->name)
                ->assertSeeIn("tr:last-child td[field-key='website']", $adword->website->website)
                ->assertSeeIn("tr:last-child td[field-key='client_customer_id']", $adword->client_customer_id)
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $adword->clinic->nickname);
        });
    }

    public function testEditAdword()
    {
        $admin = \App\User::find(1);
        $adword = factory('App\Adword')->create();
        $adword2 = factory('App\Adword')->make();

        $this->browse(function (Browser $browser) use ($admin, $adword, $adword2) {
            $browser->loginAs($admin)
                ->visit(route('admin.adwords.index'))
                ->click('tr[data-entry-id="'.$adword->id.'"] .btn-info')
                ->select('company_id', $adword2->company_id)
                ->select('website_id', $adword2->website_id)
                ->type('client_customer_id', $adword2->client_customer_id)
                ->type('user_agent', $adword2->user_agent)
                ->type('client_id', $adword2->client_id)
                ->type('client_secret', $adword2->client_secret)
                ->type('refresh_token', $adword2->refresh_token)
                ->type('authorization_uri', $adword2->authorization_uri)
                ->type('redirect_uri', $adword2->redirect_uri)
                ->type('token_credential_uri', $adword2->token_credential_uri)
                ->type('scope', $adword2->scope)
                ->select('clinic_id', $adword2->clinic_id)
                ->press('Update')
                ->assertRouteIs('admin.adwords.index')
                ->assertSeeIn("tr:last-child td[field-key='company']", $adword2->company->name)
                ->assertSeeIn("tr:last-child td[field-key='website']", $adword2->website->website)
                ->assertSeeIn("tr:last-child td[field-key='client_customer_id']", $adword2->client_customer_id)
                ->assertSeeIn("tr:last-child td[field-key='clinic']", $adword2->clinic->nickname);
        });
    }

    public function testShowAdword()
    {
        $admin = \App\User::find(1);
        $adword = factory('App\Adword')->create();

        $this->browse(function (Browser $browser) use ($admin, $adword) {
            $browser->loginAs($admin)
                ->visit(route('admin.adwords.index'))
                ->click('tr[data-entry-id="'.$adword->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='company']", $adword->company->name)
                ->assertSeeIn("td[field-key='website']", $adword->website->website)
                ->assertSeeIn("td[field-key='client_customer_id']", $adword->client_customer_id)
                ->assertSeeIn("td[field-key='user_agent']", $adword->user_agent)
                ->assertSeeIn("td[field-key='client_id']", $adword->client_id)
                ->assertSeeIn("td[field-key='client_secret']", $adword->client_secret)
                ->assertSeeIn("td[field-key='refresh_token']", $adword->refresh_token)
                ->assertSeeIn("td[field-key='authorization_uri']", $adword->authorization_uri)
                ->assertSeeIn("td[field-key='redirect_uri']", $adword->redirect_uri)
                ->assertSeeIn("td[field-key='token_credential_uri']", $adword->token_credential_uri)
                ->assertSeeIn("td[field-key='scope']", $adword->scope)
                ->assertSeeIn("td[field-key='clinic']", $adword->clinic->nickname);
        });
    }
}
