<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Pengaturan Profil</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
</x-app-layout>
