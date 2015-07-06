#Laravel HTML with Twitter Boostrap Forms

The Twitter-Bootstrap is a simple front-end framework that is used in many web applications.

#Installation
```
composer require rdehnhardt/html
```

#Configuration
Add into the file app.php in providers section 
```
'Rdehnhardt\Html\HtmlServiceProvider',
```

Add into the file app.php in alias section 
```
'Form' => 'Collective\Html\FormFacade',
'Html' => 'Collective\Html\HtmlFacade',
```

#How to use
```
{!! Form::open(['method' => 'post', 'route' => ['route.store']]) !!}

    {!! Form::openGroup('title', 'Title') !!}
    {!! Form::text('title', null, ['placeholder' => 'Title']) !!}
    {!! Form::closeGroup() !!}
    
    {!! Form::openGroup('content', 'Content') !!}
    {!! Form::textarea('content', null, ['placeholder' => 'Content of post']) !!}
    {!! Form::closeGroup() !!}
    
    {!! Form::openFormActions() !!}
    {!! Form::submit('Save', ['class' => 'btn btn-primary form-action']) !!}
    {!! Form::closeFormActions() !!}

{!! Form::close() !!}
```