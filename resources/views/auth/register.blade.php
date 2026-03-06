<x-guest-layout>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role_id" :value="__('Role')" />
            <select id="role_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                name="role_id" required>
                <option value="">{{ __('Select a role') }}</option>
                <option value="3" @if(old('role_id')=='3' ) selected @endif>{{ __('Mahasiswa') }}</option>
                <option value="4" @if(old('role_id')=='4' ) selected @endif>{{ __('Dosen') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- NIM (for Mahasiswa) -->
        <div class="mt-4" id="nim-field" style="display: none;">
            <x-input-label for="nim" :value="__('NIM')" />
            <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')"
                autocomplete="nim" />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
        </div>

        <!-- Program Studi (for Mahasiswa) -->
        <div class="mt-4" id="program-studi-field" style="display: none;">
            <x-input-label for="program_studi_id" :value="__('Program Studi')" />
            <select id="program_studi_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                name="program_studi_id">
                <option value="">{{ __('Select Program Studi') }}</option>
                @foreach($programStudis as $prodi)
                <option value="{{ $prodi->id }}" @if(old('program_studi_id')==$prodi->id) selected @endif>
                    {{ $prodi->nama_prodi }}
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('program_studi_id')" class="mt-2" />
        </div>

        <!-- NIDN (for Dosen) -->
        <div class="mt-4" id="nidn-field" style="display: none;">
            <x-input-label for="nidn" :value="__('NIDN')" />
            <x-text-input id="nidn" class="block mt-1 w-full" type="text" name="nidn" :value="old('nidn')"
                autocomplete="nidn" />
            <x-input-error :messages="$errors->get('nidn')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('role_id').addEventListener('change', function() {
            const role = this.value;
            const nimField = document.getElementById('nim-field');
            const nidnField = document.getElementById('nidn-field');
            const programStudiField = document.getElementById('program-studi-field');
            const nimInput = document.getElementById('nim');
            const nidnInput = document.getElementById('nidn');
            const programStudiInput = document.getElementById('program_studi_id');

            if (role === '3') { // Mahasiswa
                nimField.style.display = 'block';
                nidnField.style.display = 'none';
                programStudiField.style.display = 'block';
                nimInput.required = true;
                nidnInput.required = false;
                programStudiInput.required = true;
            } else if (role === '4') { // Dosen
                nimField.style.display = 'none';
                nidnField.style.display = 'block';
                programStudiField.style.display = 'none';
                nimInput.required = false;
                nidnInput.required = true;
                programStudiInput.required = false;
            } else {
                nimField.style.display = 'none';
                nidnField.style.display = 'none';
                programStudiField.style.display = 'none';
                nimInput.required = false;
                nidnInput.required = false;
                programStudiInput.required = false;
            }
        });

        // Trigger change on page load if role is pre-selected
        document.getElementById('role_id').dispatchEvent(new Event('change'));
    </script>
</x-guest-layout>