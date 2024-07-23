@section('title','Olvidé mi contraseña')
<x-log-layout>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="wrap d-md-flex">
                <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                    <div class="text w-100">
                        <h2>Olvidaste tu contraseña?</h2>
                        <p>No hay problema. Envíanos el correo con el que te registraste y te enviaremos un enlace para que elijas una nueva.</p>
                    </div>
                </div>
                <div class="login-wrap p-4 p-lg-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h3 class="mb-4"></h3>
                        </div>
                    </div>
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="form-group mb-3">
                            <label class="label" for="email">Correo electrónico</label>
                            <input id="email" name="email" autocofocus autocomplete="username" value="{{ old('email', $request->email) }}" type="email" class="form-control" placeholder="Correo electrónico" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="label" for="password">Contraseña</label>
                            <input id="password" name="password" autocomplete="new-password" type="password" class="form-control" placeholder="Contraseña" required>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" required autocomplete="new-password" />
            
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />


                        <div class="form-group mb-3">
                            <label class="label" for="password_confirmation">Confirmar contraseña</label>
                            <input id="password_confirmation" name="password_confirmation" autocomplete="new-password" type="password" class="form-control" placeholder="Confirmar contraseña" required>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Cambiar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-log-layout>




