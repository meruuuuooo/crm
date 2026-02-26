<?php

use App\Models\Crm\Estimation;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list estimations', function () {
    Estimation::create(['status' => 'Draft', 'amount' => 2000, 'currency' => 'USD']);

    $this->get(route('crm.estimations.index'))
        ->assertOk()
        ->assertSee('Draft');
});

it('can show the create estimation form', function () {
    $this->get(route('crm.estimations.create'))->assertOk();
});

it('can create an estimation', function () {
    $this->post(route('crm.estimations.store'), [
        'amount'        => 3000,
        'currency'      => 'USD',
        'status'        => 'Draft',
        'estimate_date' => '2026-02-01',
        'expiry_date'   => '2026-03-01',
        'estimate_by'   => 'John Doe',
    ])->assertRedirect(route('crm.estimations.index'));

    $this->assertDatabaseHas('crm_estimations', ['amount' => 3000, 'status' => 'Draft']);
});

it('can show an estimation', function () {
    $estimation = Estimation::create(['status' => 'Sent', 'amount' => 1500, 'currency' => 'EUR']);

    $this->get(route('crm.estimations.show', $estimation))
        ->assertOk();
});

it('can show the edit estimation form', function () {
    $estimation = Estimation::create(['status' => 'Draft', 'amount' => 500, 'currency' => 'USD']);

    $this->get(route('crm.estimations.edit', $estimation))->assertOk();
});

it('can update an estimation', function () {
    $estimation = Estimation::create(['status' => 'Draft', 'amount' => 1000, 'currency' => 'USD']);

    $this->put(route('crm.estimations.update', $estimation), [
        'amount'   => 4500,
        'currency' => 'EUR',
        'status'   => 'Sent',
    ])->assertRedirect(route('crm.estimations.index'));

    $this->assertDatabaseHas('crm_estimations', ['id' => $estimation->id, 'status' => 'Sent']);
});

it('can delete an estimation', function () {
    $estimation = Estimation::create(['status' => 'Expired', 'amount' => 0, 'currency' => 'USD']);

    $this->delete(route('crm.estimations.destroy', $estimation))
        ->assertRedirect(route('crm.estimations.index'));

    $this->assertSoftDeleted('crm_estimations', ['id' => $estimation->id]);
});
