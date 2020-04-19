<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
        {!! $component->render('include.list-containee') !!}
    @can ('update', $component->getModel())
        <div class="row">
            <div class="btn-group col-xs-12">
                <a type="button" data-ajax-url="{{ $component->getModel()->getControllerRoute('listContainee') }}" class="btn btn-info btn-lg margin-right-no col-xs-12"><i class="fa fa-list margin-right-10"></i>{{ $component->translate('button.add-select-containee-item') }}</a>
            </div>
        </div>
    @endcan
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>