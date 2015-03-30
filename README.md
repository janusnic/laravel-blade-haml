# Laravel Blade Haml

A small package that adds support for compiling Blade Style Haml templates to Laravel 5 via [MtHaml](https://github.com/arnaud-lb/MtHaml).


## Installation

1. Add it to your composer.json (`"trupedia/laravel-blade-haml": "~1.0"`) and do a composer install.

2. Add the service provider to your app.php config file providers: 

`'trupedia\LaravelBladeHaml\LaravelBladeHamlServiceProvider',`



## Configuration

You can set [MtHaml](https://github.com/arnaud-lb/MtHaml) environment, options, and filters manually.  To do so, publish the config file with `php artisan vendor:publish` and edit it at /config/blade-haml.php.  For instance, to turn off auto-escaping:

	'mthaml' => array(
		'environment' => 'php',
		'options' => array(
			'enable_escaper' => false,
		),
		'filters' => array(),
	), 



## Usage

Laravel-Blade-Haml registers the ".haml.php" extension with Laravel and forwards compile requests on to MtHaml.  It compiles your Haml templates in the same way as Blade templates; the compiled template is put in app/storage/views.  Thus, you don't suffer compile times on every page load.

In other words, just put your Haml files in the regular resources/views directory and name them like "resources/views/home/whatever.haml.php".  You reference them in Laravel like normal: `view('home.whatever')`.

The Haml view files can work side-by-side with regular PHP views.

The Blade Syntax for a sample login view:

```html
@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">

        @include('layouts.partials.errors')

        <h1>Sign In!</h1>

        {!! Form::open(['route' => 'login']) !!}
            <div class="form-group">
                {!! Form::label('email', 'E-Mail:') !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Sign In', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
```

becomes now with Laravel-Blade-Haml:

```haml
@extends('layouts.master')

@section('content')
.row
    .col-md-4.col-md-offset-4
        @include('layouts.partials.errors')
        %h1 Sign In!
        {!! Form::open(['route' => 'login']) !!}
        .form-group
            {!! Form::label('email', 'E-Mail:') !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        .form-group
            {!! Form::label('password', 'Password:') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        .form-group
            {!! Form::submit('Sign In', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
@stop
```

pretty neat, isn't it? All the good Blade stuff is still available inside your new template files.

## Contributions + Credits

Thanks [Robert Reinhard](https://github.com/bkwld/laravel-haml) for the initial source-code.

## Release notes

- 1.0 - Initial Release
