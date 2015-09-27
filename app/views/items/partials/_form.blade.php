    <div class="row">
        <div class="col-lg-12">
        {{ Former::text('name')
            ->autofocus()
            ->addClass('form-control')
            ->label('What are you selling?')
            ->blockHelp('')
            ->placeholder('Item name')->autofocus()
        }}
        </div>
    </div>
    <div class="row padded-row">
        <div class="col-lg-12">
        {{ Former::textarea('description')
            ->rows(10)->columns(20)
            ->addClass('form-control')
            ->label('Tell us about it.')
            ->blockHelp('')
            ->placeholder('Item Description')
        }}
        </div>
    </div>
    <div class="row padded-row">
        <div class="col-lg-12">
        {{ Former::number('amount')
            ->addClass('form-control')
            ->label('How much are you asking?')
            ->blockHelp('Numeric value only. Please do not include dollar sign')
            ->placeholder('Amount')
        }}
        </div>
    </div>
    <div class="row padded-row">
        <div class="col-lg-12">
        {{ Former::select('categories')
            ->addClass('form-control')
            ->fromQuery($categories,'name','id')
            ->label('What kind of Item is it?')
            ->value(isset($item->category->id) ? $item->category->id : '1')
        }}
        </div>
    </div>
    @if(isset($isUpdate))
    <div class="row">
        <div class="col-lg-12 text-center" >
            <h2 class="text-shadow">Current photo</h2>
            <img class="img-responsive" src="{{{$item->present->photoSrc('edit-box')}}}">
        </div>
    </div>
    @endif
    <div class="row padded-row">
        <div class="col-lg-12">
            {{ Former::file('photo')
                ->label('What does it look like?')
                ->blockHelp('Select new image to update, or leave blank to use current')
                ->accept('image')
                ->max(20, 'MB')
                ->class('avatar-file')
             }}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-bottom-5">
        @if(!isset($isUpdate))
            <button type="submit" class="btn btn-green btn-large btn-block">
                <i class="fa fa-plus-circle fa-fw"></i>
                Create
            </button>
        @else
            <button type="submit" class="btn btn-green btn-large btn-block">
                <i class="fa fa-edit fa-fw"></i>
                Update
            </button>
        @endif
        </div>
    </div>