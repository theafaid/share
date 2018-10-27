<!-- Start Header Area -->
<header class="default-header">
	<nav class="navbar navbar-expand-lg navbar-light">
		<div class="container">
			  <a class="navbar-brand" href="{{url('')}}">
			  	<img width="125" height="30"  src="{{asset('design')}}/img/logo.png" alt="">
			  </a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
			    <ul class="navbar-nav">

					<li class="dropdown">
						<a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
							Channels
						</a>
						<div class="dropdown-menu">
							@foreach($channels as $channel)
								<a class="dropdown-item" href="{{route('channels.show', $channel->slug)}}">{{$channel->name}}</a>
							@endforeach
						</div>
					</li>

					<li class="dropdown">
						<a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
							Filter Threads By
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="{{route('threads.index')}}">Latest</a>
							<a class="dropdown-item" href="{{route('threads.index')}}?filter=popular">Popular</a>
						</div>
					</li>




					<!-- Dropdown -->
				    @auth
						<li class="dropdown">
							<a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
								{{auth()->user()->username}}
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="{{route('threads.create')}}">Create New Thread</a>
								<a class="dropdown-item" href="/threads?by={{auth()->user()->username}}">My Threads</a>
								<a class="dropdown-item" href="{{route('logout')}}">Logout</a>
							</div>
						</li>
					@else
						<li><a href="{{route('login')}}">Login</a></li>
						<li><a href="{{route('register')}}">Register</a></li>
					@endauth
				</ul>
			  </div>						
		</div>
	</nav>
</header>
<!-- End Header Area -->