<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Edit Profile
        </x-slot>

        <x-slot name="description">
            Perbarui informasi nama dan alamat email akun Anda.
        </x-slot>

        <form wire:submit="updateProfile" class="space-y-8">
            <div class="max-w-2xl space-y-8">
                <!-- Nama Lengkap -->
                <div class="space-y-3">
                    <label for="name" class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Nama Lengkap
                        </span>
                    </label>
                    <div
                        class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500">
                        <input type="text" id="name" wire:model="name" placeholder="Masukkan nama lengkap"
                            class="fi-input block w-full border-none py-3 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-transparent px-4"
                            required>
                    </div>
                    @error('name')
                        <p class="fi-fo-field-wrp-error-message text-sm text-danger-600 dark:text-danger-400 mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Alamat Email -->
                <div class="space-y-3">
                    <label for="email" class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            Alamat Email
                        </span>
                    </label>
                    <div
                        class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500">
                        <input type="email" id="email" wire:model="email" placeholder="contoh@email.com"
                            class="fi-input block w-full border-none py-3 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-transparent px-4"
                            required>
                    </div>
                    <p class="fi-fo-field-wrp-hint text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Email harus unik dan belum digunakan akun lain
                    </p>
                    @error('email')
                        <p class="fi-fo-field-wrp-error-message text-sm text-danger-600 dark:text-danger-400 mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                <x-filament::button type="submit" color="primary" size="lg">
                    <x-filament::icon icon="heroicon-m-user-circle" class="h-5 w-5 mr-2" />
                    Simpan Profile
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>
