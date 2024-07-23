@section('title','Confirmar Contraseña')
<x-log-layout>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="wrap d-md-flex">
                <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                    <div class="text w-100">
                        <h2>Hola!</h2>
                        <p>Estas en un área segura del sitio. Por favor confirma tu contraseña antes de continuar.</p>
                    </div>
                </div>
                <div class="login-wrap p-4 p-lg-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h3 class="mb-4">Confirma tu contraseña</h3>
                        </div>
                    </div>
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="label" for="password">Contraseña</label>
                            <input id="password" name="password" autocomplete="new-password" type="password" class="form-control" placeholder="Contraseña" required autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Confirmar</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-log-layout>


