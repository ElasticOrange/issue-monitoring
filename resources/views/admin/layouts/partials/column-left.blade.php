<div class="navbar-default sidebar" role="navigation">
	<div class="sidebar-nav navbar-collapse">
		<ul class="nav" id="side-menu">
			<li class="sidebar-search">
				<div class="input-group custom-search-form">
					<input type="text" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
					<button class="btn btn-default" type="button">
						<i class="fa fa-search"></i>
					</button>
				</span>
				</div>
				<!-- /input-group -->
			</li>
			<li>
				<a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
			</li>
			<li>
				<a href="{{ action('DocumentController@index') }}"><i class="fa fa-file-word-o fa-fw"></i> Documente</a>
			</li>
			<li>
				<a href="{{ action('DomainController@index') }}"><i class="fa fa-tags fa-fw"></i> Domenii</a>
			</li>
			<li>
				<a href="{{ action('StakeholderController@index') }}"><i class="fa fa-user fa-fw"></i> Stakeholderi</a>
			</li>
			<li>
				<a href="{{ action('LocationController@index') }}"><i class="fa fa-location-arrow fa-fw"></i> Locatii procedurale</a>
			</li>
			<li>
				<a href="{{ action('NewsController@index') }}"><i class="fa fa-newspaper-o fa-fw"></i> Stiri</a>
			</li>
			<li>
				<a href="{{ action('IssueController@index') }}"><i class="fa fa-archive fa-fw"></i> Initiative</a>
			</li>
			<li>
				<a href="{{ action('FlowTemplateController@index') }}"><i class="fa fa-th"></i> Template</a>
			</li>
            <li>
				<a href="{{ action('StepAutocompleteController@index') }}"><i class="fa fa-magic"></i> Stadii procedurale</a>
			</li>
			<li>
				<a href="{{ action('UserController@index') }}"><i class="fa fa-users"></i> Useri</a>
			</li>
			<li>
				<a href="{{ action('AlertController@index') }}"><i class="fa fa-bell"></i> Alerte</a>
			</li>
			<li>
				<a href="{{ action('ReportController@index') }}"><i class="fa fa-flag"></i> Rapoarte</a>
			</li>
			<li>
				<a href="{{ action('LegalNewsController@index') }}"><i class="fa fa-external-link-square"></i> Noutati legislative</a>
			</li>
		</ul>
	</div>
</div>
