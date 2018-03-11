@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Yearly Graph</div>
                <div class="panel-body">
                    <div id="expense_div"></div>
                    <?= Lava::render('LineChart', 'Expenses', 'expense_div'); ?>                    
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Note Expense</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('expense') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('total') ? ' has-error' : '' }}">
                            <label for="total" class="col-md-4 control-label">Total Expense</label>

                            <div class="col-md-6">
                                <input id="total" type="number" class="form-control" name="total" required>

                                @if ($errors->has('total'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('total') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                            <label for="time" class="col-md-4 control-label">Date</label>

                            <div class="col-md-6">
                                <input id="date" type="text" class="form-control" name="date" value="{{ old('date') }}" required>

                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>

                    
                </div>
            </div>

            
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Expense List</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->description }}</td>
                                    <td>{{ $expense->total }}</td>
                                    <td>{{ $expense->date }}</td>
                                    <td><a href="{{ url('/delete/' . $expense->id )}}">Yes</a></td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
