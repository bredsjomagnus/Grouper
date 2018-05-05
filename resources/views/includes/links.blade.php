<div class="row mainnavbarrow">
	<div id="navbar" class="navbar-collapse collapse">

		<ul class="nav navbar-nav mainnav">
			<li {{ Request::path() == "groups" ? 'class=nav-active' : '' }}>
				<a href="{{ route('groupsdashboard')}}" >Dashboard</a>
			</li>

			<li class="dropdown {{ Request::path() == 'addgroups' ? 'nav-active' : '' }}">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Add group <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="{{ route('addgroup')}}">With csv file</a></li>
					<li><a href="#">Empty group</a></li>
				</ul>
			</li>

			<li {{ Request::path() == "choices" ? 'class=nav-active' : '' }}>
				<a href="#">Add choice</a>
			</li>
		</ul>
	</div>
</div>
