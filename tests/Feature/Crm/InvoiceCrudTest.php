<?php

use App\Models\Crm\Invoice;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list invoices', function () {
    Invoice::create(['status' => 'Draft', 'amount' => 1500, 'currency' => 'USD']);

    $this->get(route('crm.invoices.index'))
        ->assertOk()
        ->assertSee('Draft');
});

it('can show the create invoice form', function () {
    $this->get(route('crm.invoices.create'))->assertOk();
});

it('can create an invoice', function () {
    $this->post(route('crm.invoices.store'), [
        'amount'         => 2500,
        'currency'       => 'USD',
        'status'         => 'Draft',
        'date'           => '2026-02-01',
        'payment_method' => 'Bank Transfer',
    ])->assertRedirect(route('crm.invoices.index'));

    $this->assertDatabaseHas('crm_invoices', ['amount' => 2500, 'status' => 'Draft']);
});

it('can show an invoice', function () {
    $invoice = Invoice::create(['status' => 'Sent', 'amount' => 3000, 'currency' => 'EUR']);

    $this->get(route('crm.invoices.show', $invoice))
        ->assertOk();
});

it('can show the edit invoice form', function () {
    $invoice = Invoice::create(['status' => 'Draft', 'amount' => 1000, 'currency' => 'USD']);

    $this->get(route('crm.invoices.edit', $invoice))->assertOk();
});

it('can update an invoice', function () {
    $invoice = Invoice::create(['status' => 'Draft', 'amount' => 1000, 'currency' => 'USD']);

    $this->put(route('crm.invoices.update', $invoice), [
        'amount'   => 5000,
        'currency' => 'USD',
        'status'   => 'Sent',
    ])->assertRedirect(route('crm.invoices.index'));

    $this->assertDatabaseHas('crm_invoices', ['id' => $invoice->id, 'status' => 'Sent', 'amount' => 5000]);
});

it('can delete an invoice', function () {
    $invoice = Invoice::create(['status' => 'Cancelled', 'amount' => 0, 'currency' => 'USD']);

    $this->delete(route('crm.invoices.destroy', $invoice))
        ->assertRedirect(route('crm.invoices.index'));

    $this->assertSoftDeleted('crm_invoices', ['id' => $invoice->id]);
});
