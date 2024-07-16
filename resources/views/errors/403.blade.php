@extends('backend.components.header')

@section('css')
<style>
    body {
        font-family: 'Arial', sans-serif;
    }
    #ErrorContainer {
        height: auto;
        min-height: 35rem;
        border: 3px solid #4eb8e5;
        border-radius: 20px;
        padding: 2rem;
        background-color: #f0f8ff;
        transition: transform 0.3s ease-in-out;
        text-align: center;
    }
    #ErrorContainer:hover {
        transform: translateY(-5px);
    }
    h1 {
        font-size: 8rem;
        border-bottom: 5px solid #f02627;
        color: #4eb8e5;
        line-height: 8rem;
        margin: 0 auto;
        display: inline-block;
        border-radius: 20px;
        padding-right: 1rem;
    }
    h2 {
        font-size: 2.5rem;
        color: #0370b9;
        margin: 1rem 0;
    }
    p {
        font-size: 1.5rem;
        color: #41465b;
        margin: 1rem 0;
    }
    @media (max-width: 768px) {
        h1 {
            font-size: 6rem;
            line-height: 6rem;
        }
        h2 {
            font-size: 2.5rem;
        }
        p {
            font-size: 1.25rem;
        }
        .btn-home, .btn-contact {
            font-size: 1rem;
            padding: 0.5rem 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-center align-items-center" id="ErrorContainer">
            <div>
                <h1 class="pe-5">403</h1>
                <h2 class="mx-5">Permission Denied</h2>
                <p class="mt-3">You do not have the necessary permissions to access this page.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
@endsection
