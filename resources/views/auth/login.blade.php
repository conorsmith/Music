@extends('app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Log In
        </div>
        <div class="panel-body">
            <form method="post" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email Address</label>
                    <div class="col-sm-10">
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password"
                               name="password"
                               class="form-control"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       name="remember"
                                >
                                Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Log In</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
