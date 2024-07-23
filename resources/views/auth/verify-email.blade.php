@section('title','Verificar correo')
<x-log-layout>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="wrap d-md-flex">
                <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                    <div class="text w-100">
                        <h2>Gracias por sumarte a la comunidad</h2>
                        <p>Antes de comenzar, podrías verificar tu correo dando click al enlace que te envíamos por correo? Si no lo has recibido, con gusto te lo envíamos de nuevo</p>
                    </div>
                </div>
                <div class="login-wrap p-4 p-lg-5">
                    <div class="d-flex">
                        <div class="w-100">
                            <h3 class="mb-4"></h3>
                        </div>
                    </div>
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Reenviar correo de verificación</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Cerrar Sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-log-layout>



