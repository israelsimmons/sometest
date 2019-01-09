@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Register Share</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('shares.store') }}" aria-label="{{ __('Share Save') }}" novalidate>
                        @csrf

                        <div class="form-group row">
                            <label for="company_name" class="col-sm-4 col-form-label text-md-right">{{ __('Company Name') }}</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ old('company_name') }}" required autofocus>

                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="instrument_name" class="col-sm-4 col-form-label text-md-right">{{ __('Instrument Name') }}</label>

                            <div class="col-md-6">
                                <input id="instrument_name" type="text" class="form-control{{ $errors->has('instrument_name') ? ' is-invalid' : '' }}" name="instrument_name" value="{{ old('instrument_name') }}" required autofocus>

                                @if ($errors->has('instrument_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('instrument_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="col-sm-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                            <div class="col-md-6">
                                <input id="quantity" type="text" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity') }}" required autofocus>

                                @if ($errors->has('quantity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-sm-4 col-form-label text-md-right">{{ __('Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}" required autofocus>

                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_investment" class="col-sm-4 col-form-label text-md-right">{{ __('Total Investment') }}</label>

                            <div class="col-md-6">
                                <input id="total_investment" type="text" class="form-control{{ $errors->has('total_investment') ? ' is-invalid' : '' }}" name="total_investment" value="{{ old('total_investment') }}" required autofocus>

                                @if ($errors->has('total_investment'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('total_investment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="certificate_number" class="col-sm-4 col-form-label text-md-right">{{ __('Certificate Number') }}</label>

                            <div class="col-md-6">
                                <input id="certificate_number" type="text" class="form-control{{ $errors->has('certificate_number') ? ' is-invalid' : '' }}" name="certificate_number" value="{{ old('certificate_number') }}" required autofocus>

                                @if ($errors->has('certificate_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('certificate_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="transaction_date" class="col-sm-4 col-form-label text-md-right">{{ __('Transaction Date') }}</label>

                            <div class="col-md-6">
                                <input id="transaction_date" type="text" class="form-control{{ $errors->has('transaction_date') ? ' is-invalid' : '' }}" name="transaction_date" value="{{ old('transaction_date') }}" required autofocus>

                                @if ($errors->has('transaction_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('transaction_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Share</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
