@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('auth.title.register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Name --}}
                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.email_address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.confirm_password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div class="row mb-3">
                                <label for="gender"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.gender') }}</label>

                                <div class="col-md-6">
                                    <select name="gender" id="gender"
                                        class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">{{ __('auth.select_gender') }}</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                            {{ __('auth.male') }}
                                        </option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                            {{ __('auth.female') }}
                                        </option>
                                    </select>
                                </div>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Hobbies --}}
                            <div class="row mb-3">
                                <label for="hobbies"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.hobbies') }}</label>

                                <div class="col-md-6" id="hobbies-container">
                                    {{-- Default 3 hobby inputs --}}
                                    @for ($i = 0; $i < 3; $i++)
                                        <div class="hobby-input-group">
                                            <input type="text" name="hobbies[]"
                                                class="form-control mb-2 @error('hobbies.*') is-invalid @enderror"
                                                value="{{ old('hobbies.' . $i) }}"
                                                placeholder="{{ __('auth.hobbies_placeholder') }}">
                                        </div>
                                    @endfor

                                    {{-- Remove first hobby button (disabled initially) --}}
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="remove-hobby-btn"
                                        disabled>{{ '- ' . __('auth.remove_hobby') }}</button>

                                    {{-- Add more button --}}
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        id="add-hobby-btn">{{ '+ ' . __('auth.add_hobby') }}</button>

                                    @error('hobbies.*')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            {{-- Instagram username --}}
                            <div class="row mb-3">
                                <label for="instagram_username"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.insta_username') }}</label>

                                <div class="col-md-6">
                                    <input id="instagram_username" type="text"
                                        placeholder="{{ __('auth.insta_placeholder') }}"
                                        class="form-control @error('instagram_username') is-invalid @enderror"
                                        value="{{ old('instagram_username') }}" name="instagram_username" required>
                                </div>

                                @error('instagram_username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Mobile Number --}}
                            <div class="row mb-3">
                                <label for="mobile_number"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.mobile_number') }}</label>

                                <div class="col-md-6">
                                    <input id="mobile_number" type="text"
                                        placeholder="{{ __('auth.mobile_placeholder') }}"
                                        class="form-control @error('mobile_number') is-invalid @enderror"
                                        name="mobile_number" value="{{ old('mobile_number') }}" required>
                                </div>

                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Preferred Meeting Location --}}
                            <div class="row mb-3">
                                <label for="preferred_location"
                                    class="col-md-4 col-form-label text-md-end">{{ __('auth.pref_loc') }}</label>
                                <div class="col-md-6">
                                    <input type="text" name="preferred_location"
                                        class="form-control @error('preferred_location') is-invalid @enderror"
                                        value="{{ old('preferred_location') }}"
                                        placeholder="{{ __('auth.pref_loc_placeholder') }}">
                                    @error('preferred_location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Register Button --}}
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('auth.title.register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const hobbiesContainer = document.getElementById("hobbies-container");
            const removeHobbyBtn = document.getElementById("remove-hobby-btn");
            const addHobbyBtn = document.getElementById("add-hobby-btn");

            // Enable/disable remove button based on number of inputs
            const toggleRemoveButton = () => {
                const hobbyCount = hobbiesContainer.querySelectorAll('.hobby-input-group').length;
                removeHobbyBtn.disabled = hobbyCount <= 3; // Disable remove button if there are 3 or less
            };

            // Add hobby input
            addHobbyBtn.addEventListener("click", () => {
                const newHobbyDiv = document.createElement("div");
                newHobbyDiv.classList.add("hobby-input-group");

                const newHobbyInput = document.createElement("input");
                newHobbyInput.type = "text";
                newHobbyInput.name = "hobbies[]";
                newHobbyInput.className = "form-control mb-2";
                newHobbyInput.placeholder =
                    "{{ __('auth.hobbies_placeholder') }}";

                newHobbyDiv.appendChild(newHobbyInput);
                hobbiesContainer.insertBefore(newHobbyDiv, addHobbyBtn);

                toggleRemoveButton();
            });

            // Remove hobby input (for the first three inputs)
            removeHobbyBtn.addEventListener("click", () => {
                if (hobbiesContainer.querySelectorAll('.hobby-input-group').length > 3) {
                    const firstHobbyInput = hobbiesContainer.querySelector('.hobby-input-group');
                    firstHobbyInput.remove();
                    toggleRemoveButton();
                }
            });

            // Initial toggle of remove button based on default input count
            toggleRemoveButton();
        });
    </script>
@endsection
