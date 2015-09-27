{{-- Builds the item search box --}}
<div class="content-box">
    <dl class="clear-margin">
        @if (!isset($submarket))
        <dt class="dl-header weight-mid medium-small">Marketplace</dt>
        @else
        <dt class="dl-header weight-mid medium-small">{{{$submarket}}}</dt>
        @endif
        <dd class="dl-content">
            {{Former::open()->action( route('marketplace') )->method('get')}}
            {{Former::text('q')->autofocus()->placeholder('Search')->label('')->addClass('form-control')}}
            {{Former::close()}}
        </dd>
        <dd class="dl-content">
            {{Former::open()->action( route('items.modify') )}}
            {{Former::select('itemsGroupBy')->options([
                'created_at' => 'Date Created',
                'updated_at' => 'Date Updated',
                'amount'  => 'Amount',
                'name'  => 'Name'
            ])
            ->addClass('form-control')
            ->label('')
            ->value(Session::get('itemsGroupBy'))
            ->onchange('this.form.submit()')
            }}
            {{Former::close()}}
        </dd>
        <dd class="dl-content">
            {{Former::open()->action( route('items.modify') )}}
            {{Former::select('itemsSortOrder')->options([
                'desc'  => 'Descending',
                'asc'  => 'Ascending'
            ])
            ->addClass('form-control')
            ->label('')
            ->value(Session::get('itemsSortOrder'))
            ->onchange('this.form.submit()')
            }}
            {{Former::close()}}
        </dd>
    </dl>

</div>