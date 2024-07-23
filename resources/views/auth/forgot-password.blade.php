

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
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="label" for="email">Correo electrónico</label>
                            <input id="email" name="email" autocofocus type="email" class="form-control" placeholder="Correo electrónico" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Obtener enlace</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-log-layout>



