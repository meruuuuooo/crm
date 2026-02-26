<?php

use App\Models\Crm\Lead;
use App\Models\Crm\Company;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list leads', function () {
    Lead::create(['lead_name' => 'Hot Lead', 'lead_type' => 'individual', 'visibility' => 'public']);

    $this->get(route('crm.leads.index'))
        ->assertOk()
        ->assertSee('Hot Lead');
});

it('can show the create lead form', function () {
    $this->get(route('crm.leads.create'))->assertOk();
});

it('can create a lead', function () {
    $this->post(route('crm.leads.store'), [
        'lead_name'  => 'New Lead',
        'lead_type'  => 'individual',
        'source'     => 'Website',
        'visibility' => 'public',
    ])->assertRedirect(route('crm.leads.index'));

    $this->assertDatabaseHas('crm_leads', ['lead_name' => 'New Lead']);
});

it('requires lead_name and lead_type to create a lead', function () {
    $this->post(route('crm.leads.store'), [
        'visibility' => 'public',
    ])->assertSessionHasErrors(['lead_name', 'lead_type']);
});

it('can show a lead', function () {
    $lead = Lead::create(['lead_name' => 'Show Lead', 'lead_type' => 'company', 'visibility' => 'public']);

    $this->get(route('crm.leads.show', $lead))
        ->assertOk()
        ->assertSee('Show Lead');
});

it('can show the edit lead form', function () {
    $lead = Lead::create(['lead_name' => 'Edit Lead', 'lead_type' => 'individual', 'visibility' => 'public']);

    $this->get(route('crm.leads.edit', $lead))
        ->assertOk()
        ->assertSee('Edit Lead');
});

it('can update a lead', function () {
    $lead = Lead::create(['lead_name' => 'Old Lead', 'lead_type' => 'individual', 'visibility' => 'public']);

    $this->put(route('crm.leads.update', $lead), [
        'lead_name'  => 'Updated Lead',
        'lead_type'  => 'company',
        'visibility' => 'public',
    ])->assertRedirect(route('crm.leads.index'));

    $this->assertDatabaseHas('crm_leads', ['id' => $lead->id, 'lead_name' => 'Updated Lead']);
});

it('can delete a lead', function () {
    $lead = Lead::create(['lead_name' => 'Delete Lead', 'lead_type' => 'individual', 'visibility' => 'public']);

    $this->delete(route('crm.leads.destroy', $lead))
        ->assertRedirect(route('crm.leads.index'));

    $this->assertSoftDeleted('crm_leads', ['id' => $lead->id]);
});
