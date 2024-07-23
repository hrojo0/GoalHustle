
@section('title','Iniciar Sesión')

<x-log-layout>
    
	<div class="row justify-content-center">
		<div class="col-md-12 col-lg-10">
			<div class="wrap d-md-flex">
				<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
					<div class="text w-100">
						<h2>Hola!</h2>
						<p>No tienes cuenta?</p>
						<a href="{{ route('register') }}" class="btn btn-white btn-outline-white">Regístrate</a>
					</div>
				</div>
				<div class="login-wrap p-4 p-lg-5">
					<div class="d-flex">
						<div class="w-100">
							<h3 class="mb-4">Iniciar sesión</h3>
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
					<form method="POST" action="{{ route('login') }}">
						@csrf
						<div class="form-group mb-3">
							<label class="label" for="email">Correo electrónico</label>
							<input name="email" id="email" type="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email') }}" autofocus required>
							<x-input-error :messages="$errors->get('email')" class="mt-2" />
						</div>
						<div class="form-group mb-3">
							<label class="label" for="password">Contraseña</label>
							<input id="password" name="password" autocomplete="current-password" type="password" class="form-control" placeholder="Contraseña" required>
							<x-input-error :messages="$errors->get('password')" class="mt-2" />
						</div>
						<div class="form-group">
							<button type="submit" class="form-control btn btn-primary submit px-3">Entrar</button>
						</div>
						<div class="form-group d-md-flex">
							<div class="w-50 text-left">
								<label class="checkbox-wrap checkbox-primary mb-0">No cerrar sesión
									<input id="remember_me" name="remember" type="checkbox" checked>
									<span class="checkmark"></span>
								</label>
							</div>
							@if(Route::has('password.request'))
							<div class="w-50 text-md-right">
								<a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
							</div>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</x-log-layout>


