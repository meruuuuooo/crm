<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="CRM" class="grid">
                    <flux:sidebar.item icon="building-office-2" :href="route('crm.companies.index')" :current="request()->routeIs('crm.companies.*')" wire:navigate>
                        {{ __('Companies') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" :href="route('crm.contacts.index')" :current="request()->routeIs('crm.contacts.*')" wire:navigate>
                        {{ __('Contacts') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="funnel" :href="route('crm.leads.index')" :current="request()->routeIs('crm.leads.*')" wire:navigate>
                        {{ __('Leads') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="currency-dollar" :href="route('crm.deals.index')" :current="request()->routeIs('crm.deals.*')" wire:navigate>
                        {{ __('Deals') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="arrows-right-left" :href="route('crm.pipelines.index')" :current="request()->routeIs('crm.pipelines.*')" wire:navigate>
                        {{ __('Pipelines') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="Work" class="grid">
                    <flux:sidebar.item icon="briefcase" :href="route('crm.projects.index')" :current="request()->routeIs('crm.projects.*')" wire:navigate>
                        {{ __('Projects') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="check-badge" :href="route('crm.tasks.index')" :current="request()->routeIs('crm.tasks.*')" wire:navigate>
                        {{ __('Tasks') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('crm.activities.index')" :current="request()->routeIs('crm.activities.*')" wire:navigate>
                        {{ __('Activities') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="megaphone" :href="route('crm.campaigns.index')" :current="request()->routeIs('crm.campaigns.*')" wire:navigate>
                        {{ __('Campaigns') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="Finance" class="grid">
                    <flux:sidebar.item icon="document-text" :href="route('crm.proposals.index')" :current="request()->routeIs('crm.proposals.*')" wire:navigate>
                        {{ __('Proposals') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="clipboard-document-check" :href="route('crm.contracts.index')" :current="request()->routeIs('crm.contracts.*')" wire:navigate>
                        {{ __('Contracts') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calculator" :href="route('crm.estimations.index')" :current="request()->routeIs('crm.estimations.*')" wire:navigate>
                        {{ __('Estimations') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="banknotes" :href="route('crm.invoices.index')" :current="request()->routeIs('crm.invoices.*')" wire:navigate>
                        {{ __('Invoices') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="Insights" class="grid">
                    <flux:sidebar.item icon="chart-bar" :href="route('crm.reports.index')" :current="request()->routeIs('crm.reports.*')" wire:navigate>
                        {{ __('Reports') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="code-bracket-square" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
