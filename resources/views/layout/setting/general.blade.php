<div class="quicklink-sidebar-menu ctm-border-radius shadow-sm grow bg-white card">
  <div class="card-body">
    <ul class="list-group list-group-horizontal-lg">
			
	@if (in_array("17", permission()))
        <li class="list-group-item sub_tabs text-center button-6 {{ active_class(['education']) }}"><a href="{{ route('education.index')}}" class="{{ active_textclass(['education']) }}">Education</a></li>
      @endif
      @if (in_array("38", permission()))
        <li class="list-group-item sub_tabs text-center button-6 {{ active_class(['bank']) }}"><a href="{{ route('bank.index')}}" class="{{ active_textclass(['bank']) }}">Bank</a></li>
      @endif
     
    </ul>
  </div>
</div>