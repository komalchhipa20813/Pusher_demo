
<div class="quicklink-sidebar-menu ctm-border-radius shadow-sm grow bg-white card">
	<div class="card-body">
		<ul class="list-group list-group-horizontal-lg">
			<li class="list-group-item text-center button-5 {{ active_class(['country','state','city','location']) }} "><a href="{{route('country.index')}}" class="{{ active_textclass(['country','state','city','location']) }} ">Address</a></li>

			<li class="list-group-item text-center button-6 {{ active_class(['education','bank']) }} "
			>
			<a href="{{ route('education.index')}}" 
			class="{{ active_textclass(['education','bank']) }} ">General</a></li>
		</ul>
	</div>
</div>