<div class="row mainnavbarrow">
	<div id="navbar" class="navbar-collapse collapse">

		<ul class="nav navbar-nav mainnav">
			<li {{ Request::path() == "groups" ? 'class=nav-active' : '' }}>
				<a href="{{ route('groupsdashboard')}}" >DASHBOARD</a>
			</li>

			<li class="dropdown {{ Request::path() == 'groups/addgroups' ? 'nav-active' : '' }}">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ADD GROUP <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="{{ route('addgroups')}}">With csv file</a></li>
					<li><a href="#">Empty group</a></li>
				</ul>
			</li>

			<li class="dropdown {{ Request::path() == 'choices/addchoices' ? 'nav-active' : '' }}">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ADD CHOICE <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="{{ route('addchoices')}}">With csv file</a></li>
					<li><a href="#">One at a time</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>
