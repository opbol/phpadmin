@if ($socialProviders)
<div class="social-auth-links text-center">
    <p>- OR -</p>
    @if (in_array('facebook', $socialProviders))
    <a href="{{ url('auth/facebook/login') }}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i>
        Sign in using Facebook
    </a>
    @endif
    @if (in_array('twitter', $socialProviders))
    <a href="{{ url('auth/twitter/login') }}" class="btn btn-block btn-social btn-twitter btn-flat"><i class="fa fa-twitter"></i>
        Sign in using Twitter
    </a>
    @endif
    @if (in_array('google', $socialProviders))
    <a href="{{ url('auth/google/login') }}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i>
        Sign in using Google+
    </a>
    @endif
</div>
@endif