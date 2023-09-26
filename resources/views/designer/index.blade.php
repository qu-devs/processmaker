@extends('layouts.layout')

@section('title')
{{__('Designer')}}
@endsection

@section('sidebar')
    @include('layouts.sidebar', ['sidebar'=> Menu::get('sidebar_processes')])
@endsection

@section('breadcrumbs')
    @include('shared.breadcrumbs', ['routes' => [
        __('Designer') => route('designer.index'),
    ]])
@endsection
@section('content')
<div id="new-designer" class="px-3 page-content mb-0">
    <div class="card card-body">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <assets />
                    </div>
                    <div class="col-12">
                        <my-project />
                    </div>
                </div>
            </div>
            <div class="col-6">
                <recent-assets />
            </div>
        </div>
     </div>
</div>
@endsection

@section('js')
<script src="{{mix('js/processes/newDesigner.js')}}"></script>
@endsection
