<?php

use App\Models\Crm\Company;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list companies', function () {
    Company::create([
        'company_name' => 'Acme Corp',
        'visibility'   => 'public',
    ]);

    $this->get(route('crm.companies.index'))
        ->assertOk()
        ->assertSee('Acme Corp');
});

it('can show the create company form', function () {
    $this->get(route('crm.companies.create'))
        ->assertOk();
});

it('can create a company', function () {
    $this->post(route('crm.companies.store'), [
        'company_name' => 'New Company Ltd',
        'email'        => 'info@newcompany.com',
        'phone_1'      => '555-1234',
        'source'       => 'Website',
        'industry'     => 'Technology',
        'visibility'   => 'public',
    ])->assertRedirect(route('crm.companies.index'));

    $this->assertDatabaseHas('crm_companies', ['company_name' => 'New Company Ltd']);
});

it('requires company_name to create a company', function () {
    $this->post(route('crm.companies.store'), [
        'visibility' => 'public',
    ])->assertSessionHasErrors('company_name');
});

it('can show a company', function () {
    $company = Company::create(['company_name' => 'Show Me', 'visibility' => 'public']);

    $this->get(route('crm.companies.show', $company))
        ->assertOk()
        ->assertSee('Show Me');
});

it('can show the edit company form', function () {
    $company = Company::create(['company_name' => 'Edit Me', 'visibility' => 'public']);

    $this->get(route('crm.companies.edit', $company))
        ->assertOk()
        ->assertSee('Edit Me');
});

it('can update a company', function () {
    $company = Company::create(['company_name' => 'Old Name', 'visibility' => 'public']);

    $this->put(route('crm.companies.update', $company), [
        'company_name' => 'Updated Name',
        'visibility'   => 'private',
    ])->assertRedirect(route('crm.companies.index'));

    $this->assertDatabaseHas('crm_companies', ['id' => $company->id, 'company_name' => 'Updated Name']);
});

it('can delete a company', function () {
    $company = Company::create(['company_name' => 'Delete Me', 'visibility' => 'public']);

    $this->delete(route('crm.companies.destroy', $company))
        ->assertRedirect(route('crm.companies.index'));

    $this->assertSoftDeleted('crm_companies', ['id' => $company->id]);
});
