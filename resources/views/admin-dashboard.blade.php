@extends('layouts/admin-bar')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-lg-12">
                <div class="card">

                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div>
                        <router-view></router-view>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

