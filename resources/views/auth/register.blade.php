@section('title', 'Registro de usuarios')
<x-log-layout>

    <div class="row justify-content-center">
		<div class="col-md-12 col-lg-10">
			<div class="wrap d-md-flex">
				<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
					<div class="text w-100">
						<h2>Hola!</h2>
						<p>Ya tienes cuenta?</p>
						<a href="{{ route('login') }}" class="btn btn-white btn-outline-white">Inicia sesión</a>
					</div>
				</div>
				<div class="login-wrap p-4 p-lg-5">
					<div class="d-flex">
						<div class="w-100">
							<h3 class="mb-4">Registro</h3>
						</div>
						<div class="w-100">
							<p class="social-media d-flex justify-content-end">
								<a href="#"
									class="social-icon d-flex align-items-center justify-content-center"><span
										class="fa fa-facebook"></span></a>
								<a href="#"
									class="social-icon d-flex align-items-center justify-content-center"><span
										class="fa fa-twitter"></span></a>
							</p>
						</div>
					</div>
					<x-auth-session-status class="mb-4" :status="session('status')" />
					<form method="POST" action="{{ route('register') }}">
						@csrf
						<div class="form-group mb-3">
							<label class="label" for="name">Nombre</label>
							<input name="name" id="name" type="text" class="form-control" placeholder="Nombre" value="{{ old('name') }}" autofocus required>
							<x-input-error :messages="$errors->get('name')" class="mt-2" />
						</div>
                        <div class="form-group mb-3">
							<label class="label" for="email">Correo electrónico</label>
							<input name="email" id="email" type="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email') }}" autofocus required>
							<x-input-error :messages="$errors->get('email')" class="mt-2" />
						</div>
						<div class="form-group mb-3">
							<label class="label" for="password">Contraseña</label>
							<input id="password" name="password" autocomplete="new-password" type="password" class="form-control" placeholder="Contraseña" required>
							<x-input-error :messages="$errors->get('password')" class="mt-2" />
						</div>
                        <div class="form-group mb-3">
							<label class="label" for="password_confirmation">Confirmar Contraseña</label>
							<input id="password_confirmation" name="password_confirmation" autocomplete="new-password" 
                                    type="password" class="form-control" placeholder="Confirmar contraseña" required>
							<x-input-error :messages="$errors->get('password')" class="mt-2" />
						</div>
						<div class="form-group">
							<button type="submit" class="form-control btn btn-primary submit px-3">Registrarse</button>
						</div>
                        
					</form>
				</div>
			</div>
		</div>
	</div>

</x-log-layout>
