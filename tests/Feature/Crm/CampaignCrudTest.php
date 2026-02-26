<?php

use App\Models\Crm\Campaign;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list campaigns', function () {
    Campaign::create(['name' => 'Spring Sale', 'campaign_type' => 'Email']);

    $this->get(route('crm.campaigns.index'))
        ->assertOk()
        ->assertSee('Spring Sale');
});

it('can show the create campaign form', function () {
    $this->get(route('crm.campaigns.create'))->assertOk();
});

it('can create a campaign', function () {
    $this->post(route('crm.campaigns.store'), [
        'name'          => 'Summer Push',
        'campaign_type' => 'Social Media',
        'deal_value'    => 10000,
        'currency'      => 'USD',
        'period'        => 'Monthly',
    ])->assertRedirect(route('crm.campaigns.index'));

    $this->assertDatabaseHas('crm_campaigns', ['name' => 'Summer Push']);
});

it('requires name to create a campaign', function () {
    $this->post(route('crm.campaigns.store'), [
        'campaign_type' => 'Email',
    ])->assertSessionHasErrors('name');
});

it('can show a campaign', function () {
    $campaign = Campaign::create(['name' => 'Show Campaign', 'campaign_type' => 'SMS']);

    $this->get(route('crm.campaigns.show', $campaign))
        ->assertOk()
        ->assertSee('Show Campaign');
});

it('can show the edit campaign form', function () {
    $campaign = Campaign::create(['name' => 'Edit Campaign', 'campaign_type' => 'Email']);

    $this->get(route('crm.campaigns.edit', $campaign))
        ->assertOk()
        ->assertSee('Edit Campaign');
});

it('can update a campaign', function () {
    $campaign = Campaign::create(['name' => 'Old Campaign', 'campaign_type' => 'Email']);

    $this->put(route('crm.campaigns.update', $campaign), [
        'name'          => 'Updated Campaign',
        'campaign_type' => 'Content',
    ])->assertRedirect(route('crm.campaigns.index'));

    $this->assertDatabaseHas('crm_campaigns', ['id' => $campaign->id, 'name' => 'Updated Campaign']);
});

it('can delete a campaign', function () {
    $campaign = Campaign::create(['name' => 'Delete Campaign', 'campaign_type' => 'Event']);

    $this->delete(route('crm.campaigns.destroy', $campaign))
        ->assertRedirect(route('crm.campaigns.index'));

    $this->assertSoftDeleted('crm_campaigns', ['id' => $campaign->id]);
});
