<ul class="nav navbar-top-links navbar-right" style="margin-right: 0px;">
	<li>
		<a href="{{ action('HomeController@getIndex') }}">
			Interfata client 
		</a>
	</li>
	<li class="dropdown">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fa fa-user fa-fw"></i>
			<i class="fa fa-caret-down"></i>
		</a>
	<ul class="dropdown-menu dropdown-user">
			<li>
				<a href="{{ action('UserController@profile') }}">
					<i class="fa fa-user fa-fw"></i>
					User Profile
				</a>
			</li>
			<li class="divider">
			</li>
			<li>
				<a href="/auth/logout" id="logout">
					<i class="fa fa-sign-out fa-fw"></i>
					Logout
				</a>
			</li>
		</ul>
	</li>
</ul>
