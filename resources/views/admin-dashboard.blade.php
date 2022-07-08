@extends('layouts/admin-bar')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-lg-12">
                <div class="card">
                    @if($title === 'Admin Page')
                        <div class="card-header">{{ __('Dashboard') }}</div>
                    @endif
                    <div>
                        <router-view></router-view>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

