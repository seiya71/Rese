@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>お支払い金額を入力してください</h2>

        <form action="{{ route('payment.charge') }}" method="POST">
            @csrf
            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

            <div class="form-group">
                <label for="amount">金額（円）</label>
                <input type="number" name="amount" id="amount" class="form-control" required min="1">
            </div>

            <button type="submit" class="btn btn-primary mt-3">支払いに進む</button>
        </form>
    </div>
@endsection