
<section class="widget profile-widget version-ii hidden-sm hidden-xs wow fadeInUp" data-wow-delay="0.4s">
    <div class="profile-pic">
        <a href="#">
            <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : asset('img/user-default.png')}}" alt="John Aston">
        </a>
    </div>
    <h3>{{ $profile->user->name }}</h3>
    <p>Hola, soy {{ $profile->profession }}</p>
    <p>{{ $profile->about }}</p>
    <!-- Social Network of the page -->
    <ul class="social-networks">
        <li><a href="{{ $profile->facebook }}"><span class="icon ico-facebook"></span></a></li>
        <li><a href="{{ $profile->twitter }}"><span class="icon ico-twitter"></span></a></li>
        <li><a href="{{ $profile->linkedin }}"><span class="icon ico-linkedin"></span></a></li>
    </ul>
    <!-- Social Network of the page -->
</section>