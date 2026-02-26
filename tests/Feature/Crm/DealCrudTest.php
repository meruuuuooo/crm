<?php

use App\Models\Crm\Deal;
use App\Models\Crm\Pipeline;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->pipeline = Pipeline::create([
        'name'        => 'Test Pipeline',
        'access_type' => 'public',
        'stages'      => ['Lead', 'Won'],
    ]);
});

it('can list deals', function () {
    Deal::create(['deal_name' => 'Big Deal', 'pipeline_id' => $this->pipeline->id]);

    $this->get(route('crm.deals.index'))
        ->assertOk()
        ->assertSee('Big Deal');
});

it('can show the create deal form', function () {
    $this->get(route('crm.deals.create'))->assertOk();
});

it('can create a deal', function () {
    $this->post(route('crm.deals.store'), [
        'deal_name'  => 'New Deal',
        'pipeline_id'=> $this->pipeline->id,
        'status'     => 'New',
        'deal_value' => 5000,
        'currency'   => 'USD',
        'priority'   => 'High',
    ])->assertRedirect(route('crm.deals.index'));

    $this->assertDatabaseHas('crm_deals', ['deal_name' => 'New Deal']);
});

it('requires deal_name to create a deal', function () {
    $this->post(route('crm.deals.store'), [
        'pipeline_id' => $this->pipeline->id,
    ])->assertSessionHasErrors('deal_name');
});

it('can show a deal', function () {
    $deal = Deal::create(['deal_name' => 'Show Deal', 'pipeline_id' => $this->pipeline->id]);

    $this->get(route('crm.deals.show', $deal))
        ->assertOk()
        ->assertSee('Show Deal');
});

it('can show the edit deal form', function () {
    $deal = Deal::create(['deal_name' => 'Edit Deal', 'pipeline_id' => $this->pipeline->id]);

    $this->get(route('crm.deals.edit', $deal))
        ->assertOk()
        ->assertSee('Edit Deal');
});

it('can update a deal', function () {
    $deal = Deal::create(['deal_name' => 'Old Deal', 'pipeline_id' => $this->pipeline->id]);

    $this->put(route('crm.deals.update', $deal), [
        'deal_name'   => 'Updated Deal',
        'pipeline_id' => $this->pipeline->id,
        'status'      => 'Won',
    ])->assertRedirect(route('crm.deals.index'));

    $this->assertDatabaseHas('crm_deals', ['id' => $deal->id, 'deal_name' => 'Updated Deal', 'status' => 'Won']);
});

it('can delete a deal', function () {
    $deal = Deal::create(['deal_name' => 'Delete Deal', 'pipeline_id' => $this->pipeline->id]);

    $this->delete(route('crm.deals.destroy', $deal))
        ->assertRedirect(route('crm.deals.index'));

    $this->assertSoftDeleted('crm_deals', ['id' => $deal->id]);
});
