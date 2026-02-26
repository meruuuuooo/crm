<?php

use App\Models\Crm\Contract;
use App\Models\Crm\Contact;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list contracts', function () {
    Contract::create(['subject' => 'Service Agreement 2026', 'contract_type' => 'Service Agreement']);

    $this->get(route('crm.contracts.index'))
        ->assertOk()
        ->assertSee('Service Agreement 2026');
});

it('can show the create contract form', function () {
    $this->get(route('crm.contracts.create'))->assertOk();
});

it('can create a contract', function () {
    $this->post(route('crm.contracts.store'), [
        'subject'        => 'New Contract',
        'contract_type'  => 'NDA',
        'contract_value' => 50000,
        'start_date'     => '2026-01-01',
        'end_date'       => '2027-01-01',
    ])->assertRedirect(route('crm.contracts.index'));

    $this->assertDatabaseHas('crm_contracts', ['subject' => 'New Contract']);
});

it('requires subject to create a contract', function () {
    $this->post(route('crm.contracts.store'), [
        'contract_type' => 'NDA',
    ])->assertSessionHasErrors('subject');
});

it('can show a contract', function () {
    $contract = Contract::create(['subject' => 'Show Contract', 'contract_type' => 'Partnership']);

    $this->get(route('crm.contracts.show', $contract))
        ->assertOk()
        ->assertSee('Show Contract');
});

it('can show the edit contract form', function () {
    $contract = Contract::create(['subject' => 'Edit Contract', 'contract_type' => 'NDA']);

    $this->get(route('crm.contracts.edit', $contract))
        ->assertOk()
        ->assertSee('Edit Contract');
});

it('can update a contract', function () {
    $contract = Contract::create(['subject' => 'Old Contract', 'contract_type' => 'NDA']);

    $this->put(route('crm.contracts.update', $contract), [
        'subject'        => 'Updated Contract',
        'contract_type'  => 'Vendor',
        'contract_value' => 75000,
    ])->assertRedirect(route('crm.contracts.index'));

    $this->assertDatabaseHas('crm_contracts', ['id' => $contract->id, 'subject' => 'Updated Contract']);
});

it('can delete a contract', function () {
    $contract = Contract::create(['subject' => 'Delete Contract', 'contract_type' => 'Other']);

    $this->delete(route('crm.contracts.destroy', $contract))
        ->assertRedirect(route('crm.contracts.index'));

    $this->assertSoftDeleted('crm_contracts', ['id' => $contract->id]);
});
