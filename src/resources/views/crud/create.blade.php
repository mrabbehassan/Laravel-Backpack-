@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.add') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')

@endsection

@section('content')

<div class="row">
	<div class="{{ $crud->getCreateContentClass() }}">
		{{-- Default box --}}

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route) }}"
				@if ($crud->hasUploadFields())
				enctype="multipart/form-data"
				@endif
		  		>
			  {!! csrf_field() !!}
		      {{-- load the view from the application if it exists, otherwise load the one in the package --}}
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $crud->fields(), 'action' => 'create' ])
		      @endif
                {{-- This makes sure that all field assets are loaded. --}}
                <div class="d-none" id="parentLoadedAssets">{{ json_encode(Basset::loaded()) }}</div>
	          @include('crud::inc.form_save_buttons')
		  </form>
	</div>
</div>

@endsection

