<!-- resources/views/transactions/search.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Rechercher une transaction') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transaction.find') }}">
                        @csrf
                        <div class="form-group">
                            <label for="hash">{{ __('Hash de transaction') }}</label>
                            <input id="hash" type="text" class="form-control @error('hash') is-invalid @enderror" name="hash" value="{{ old('hash') }}" required autofocus placeholder="0x...">
                            <small class="form-text text-muted">Entrez le hash de transaction pour en vérifier le statut.</small>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Rechercher') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection