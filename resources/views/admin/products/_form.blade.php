<div class="form-group">
    {!! Form::label('Category', 'categoria') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Name', 'nome') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Description', 'descricao') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Price', 'preco') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>