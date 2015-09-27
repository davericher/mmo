<div class="row">
    <div class="col-lg-12">
        @if(!isset($isUpdate))
            {{ Former::text('username')
                ->addClass('form-control')
                ->label('Username')
                ->blockHelp('I bet you can think of something super creative')
                ->placeholder('User Name')
                ->autofocus()
            }}
        @endif
        @if(isset($isUpdate))
        {{ Former::text('firstname')
            ->addClass('form-control')
            ->label('First Name')
            ->blockHelp('Even Cher has one')
            ->placeholder('First Name')
            ->autofocus()
        }}
        @else
        {{ Former::text('firstname')
            ->addClass('form-control')
            ->label('First Name')
            ->blockHelp('Even Cher has one')
            ->placeholder('First Name')
        }}
        @endif
        {{ Former::text('lastname')
            ->addClass('form-control')
            ->label('Last Name')
            ->blockHelp('It is typically the one that comes after the first')
            ->placeholder('Last Name')
        }}
        {{ Former::email('email')
            ->addClass('form-control')
            ->label('Email Address')
            ->blockHelp('So we can send the confirmation email somewhere')
            ->placeholder('Email Address')
        }}
        @if(!isset($isUpdate))
        {{ Former::password('password')
            ->addClass('form-control')
            ->label('Password')
            ->blockHelp('Helps keep things safe')
            ->placeholder('Password')
        }}
        {{ Former::password('password_confirmation')
            ->addClass('form-control')
            ->label('Please retype Password')
            ->blockHelp('Just incase you made a mistake the first go')
            ->placeholder('Confirm Password')
        }}
        @endif
        {{ Former::file('avatar')
            ->class('avatar-file')
            ->accept('image')
            ->max(20, 'MB')
        }}
        <div class="margin-bt-5">
            @if(!isset($isUpdate))
            <button type="submit" class="btn btn-green btn-large btn-block">
                <i class="fa fa-pencil fa-fw"></i>
                Sign up
            </button>
            @else
            <button type="submit" class="btn btn-green btn-large btn-block">
                <i class="fa fa-edit fa-fw"></i>
                Update
            </button>
            @endif
        </div>
    </div>
</div>
