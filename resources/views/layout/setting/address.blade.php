<div class="quicklink-sidebar-menu ctm-border-radius shadow-sm grow bg-white card">
	<div class="card-body">
		<ul class="list-group list-group-horizontal-lg">
			@if (in_array("1", permission()))
				<li class="list-group-item sub_tabs text-center button-4 {{ active_class(['country']) }}"><a href="{{ route('country.index')}}" class="{{ active_textclass(['country']) }}">Country</a></li>
			@endif
			@if (in_array("5", permission()))
				<li class="list-group-item sub_tabs text-center button-6 {{ active_class(['state']) }}"><a href="{{ route('state.index')}}" class="{{ active_textclass(['state']) }}">State</a></li>
			@endif
			@if (in_array("9", permission()))
				<li class="list-group-item sub_tabs text-center button-6 {{ active_class(['city']) }}"><a href="{{ route('city.index')}}" class="{{ active_textclass(['city']) }}">City</a></li>
			@endif
			@if (in_array("13", permission()))
				<li class="list-group-item sub_tabs text-center button-6 {{ active_class(['location']) }}"><a href="{{ route('location.index')}}" class="{{ active_textclass(['location']) }}">Location</a></li>
			@endif
			
		</ul>
	</div>
</div>