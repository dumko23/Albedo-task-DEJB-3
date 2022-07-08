@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @auth
                        <h4 class="text-center m-3">Welcome to the Admin Page, {{ Auth::user()->name }}</h4>
                        <a class="dropdown-item text-center" href="/admin/dashboard">Dashboard</a>
                    @else
                        <h4 class="text-center m-3">This is an Admin page.
                            If you don't have a permission - please,
                            leave this page!</h4>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
<script>

</script>
