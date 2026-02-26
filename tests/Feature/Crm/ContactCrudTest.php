<?php

use App\Models\Crm\Contact;
use App\Models\Crm\Company;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list contacts', function () {
    Contact::create(['first_name' => 'Jane', 'last_name' => 'Doe', 'visibility' => 'public']);

    $this->get(route('crm.contacts.index'))
        ->assertOk()
        ->assertSee('Jane');
});

it('can show the create contact form', function () {
    $this->get(route('crm.contacts.create'))->assertOk();
});

it('can create a contact', function () {
    $this->post(route('crm.contacts.store'), [
        'first_name' => 'John',
        'last_name'  => 'Smith',
        'email'      => 'john@example.com',
        'visibility' => 'public',
    ])->assertRedirect(route('crm.contacts.index'));

    $this->assertDatabaseHas('crm_contacts', ['first_name' => 'John', 'last_name' => 'Smith']);
});

it('requires first_name and last_name to create a contact', function () {
    $this->post(route('crm.contacts.store'), [
        'visibility' => 'public',
    ])->assertSessionHasErrors(['first_name', 'last_name']);
});

it('can show a contact', function () {
    $contact = Contact::create(['first_name' => 'Alice', 'last_name' => 'Jones', 'visibility' => 'public']);

    $this->get(route('crm.contacts.show', $contact))
        ->assertOk()
        ->assertSee('Alice');
});

it('can show the edit contact form', function () {
    $contact = Contact::create(['first_name' => 'Bob', 'last_name' => 'Brown', 'visibility' => 'public']);

    $this->get(route('crm.contacts.edit', $contact))
        ->assertOk()
        ->assertSee('Bob');
});

it('can update a contact', function () {
    $contact = Contact::create(['first_name' => 'Old', 'last_name' => 'Name', 'visibility' => 'public']);

    $this->put(route('crm.contacts.update', $contact), [
        'first_name' => 'New',
        'last_name'  => 'Name',
        'visibility' => 'private',
    ])->assertRedirect(route('crm.contacts.index'));

    $this->assertDatabaseHas('crm_contacts', ['id' => $contact->id, 'first_name' => 'New']);
});

it('can delete a contact', function () {
    $contact = Contact::create(['first_name' => 'Del', 'last_name' => 'Me', 'visibility' => 'public']);

    $this->delete(route('crm.contacts.destroy', $contact))
        ->assertRedirect(route('crm.contacts.index'));

    $this->assertSoftDeleted('crm_contacts', ['id' => $contact->id]);
});
