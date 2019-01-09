@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        @if($message = Session::get('message'))
            <div class="alert alert-success" role="alert">{{ $message }}</div>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Shares</div>

                <div class="card-body">
                    <div class="">
                        <a href="{{ route('shares.create') }}" class="btn btn-primary">Register New Share</a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>Instrument</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Investment</th>
                                <th>Trans. date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shares as $share)
                            <tr>
                                <td>{{ $share->company_name }}</td>
                                <td>{{ $share->instrument_name }}<br>
                                    @foreach($share->tags as $tag)
                                    <small class="badge badge-primary">{{ $tag->description }}</small>
                                    @endforeach
                                </td>
                                <td>{{ $share->quantity }}</td>
                                <td>{{ $share->price }}</td>
                                <td>{{ $share->total_investment }}</td>
                                <td>{{ $share->transaction_date }}</td>
                                <td>
                                    <a href="{{ route('shares.show', $share->id) }}" class="btn btn-success btn-small">Edit</a>
                                    <form class="" action="{{ route('shares.destroy') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="id" value="{{ $share->id}}">
                                        <button class="btn btn-small btn-danger" type="submit" value="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $shares->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
