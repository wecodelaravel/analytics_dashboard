<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TaskTagTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateTaskTag()
    {
        $admin = \App\User::find(1);
        $task_tag = factory('App\TaskTag')->make();

        $this->browse(function (Browser $browser) use ($admin, $task_tag) {
            $browser->loginAs($admin)
                ->visit(route('admin.task_tags.index'))
                ->clickLink('Add new')
                ->type('name', $task_tag->name)
                ->press('Save')
                ->assertRouteIs('admin.task_tags.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $task_tag->name);
        });
    }

    public function testEditTaskTag()
    {
        $admin = \App\User::find(1);
        $task_tag = factory('App\TaskTag')->create();
        $task_tag2 = factory('App\TaskTag')->make();

        $this->browse(function (Browser $browser) use ($admin, $task_tag, $task_tag2) {
            $browser->loginAs($admin)
                ->visit(route('admin.task_tags.index'))
                ->click('tr[data-entry-id="'.$task_tag->id.'"] .btn-info')
                ->type('name', $task_tag2->name)
                ->press('Update')
                ->assertRouteIs('admin.task_tags.index')
                ->assertSeeIn("tr:last-child td[field-key='name']", $task_tag2->name);
        });
    }

    public function testShowTaskTag()
    {
        $admin = \App\User::find(1);
        $task_tag = factory('App\TaskTag')->create();

        $this->browse(function (Browser $browser) use ($admin, $task_tag) {
            $browser->loginAs($admin)
                ->visit(route('admin.task_tags.index'))
                ->click('tr[data-entry-id="'.$task_tag->id.'"] .btn-primary')
                ->assertSeeIn("td[field-key='name']", $task_tag->name);
        });
    }
}
