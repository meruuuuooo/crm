<?php

use App\Models\Crm\Proposal;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list proposals', function () {
    Proposal::create(['subject' => 'Q1 Proposal', 'status' => 'Draft', 'currency' => 'USD']);

    $this->get(route('crm.proposals.index'))
        ->assertOk()
        ->assertSee('Q1 Proposal');
});

it('can show the create proposal form', function () {
    $this->get(route('crm.proposals.create'))->assertOk();
});

it('can create a proposal', function () {
    $this->post(route('crm.proposals.store'), [
        'subject'   => 'New Proposal',
        'status'    => 'Draft',
        'currency'  => 'USD',
        'date'      => '2026-02-01',
        'open_till' => '2026-03-01',
    ])->assertRedirect(route('crm.proposals.index'));

    $this->assertDatabaseHas('crm_proposals', ['subject' => 'New Proposal']);
});

it('requires subject to create a proposal', function () {
    $this->post(route('crm.proposals.store'), [
        'status' => 'Draft',
    ])->assertSessionHasErrors('subject');
});

it('can show a proposal', function () {
    $proposal = Proposal::create(['subject' => 'Show Proposal', 'status' => 'Sent', 'currency' => 'EUR']);

    $this->get(route('crm.proposals.show', $proposal))
        ->assertOk()
        ->assertSee('Show Proposal');
});

it('can show the edit proposal form', function () {
    $proposal = Proposal::create(['subject' => 'Edit Proposal', 'status' => 'Draft', 'currency' => 'USD']);

    $this->get(route('crm.proposals.edit', $proposal))
        ->assertOk()
        ->assertSee('Edit Proposal');
});

it('can update a proposal', function () {
    $proposal = Proposal::create(['subject' => 'Old Proposal', 'status' => 'Draft', 'currency' => 'USD']);

    $this->put(route('crm.proposals.update', $proposal), [
        'subject'  => 'Updated Proposal',
        'status'   => 'Accepted',
        'currency' => 'USD',
    ])->assertRedirect(route('crm.proposals.index'));

    $this->assertDatabaseHas('crm_proposals', ['id' => $proposal->id, 'subject' => 'Updated Proposal', 'status' => 'Accepted']);
});

it('can delete a proposal', function () {
    $proposal = Proposal::create(['subject' => 'Delete Proposal', 'status' => 'Expired', 'currency' => 'USD']);

    $this->delete(route('crm.proposals.destroy', $proposal))
        ->assertRedirect(route('crm.proposals.index'));

    $this->assertSoftDeleted('crm_proposals', ['id' => $proposal->id]);
});
