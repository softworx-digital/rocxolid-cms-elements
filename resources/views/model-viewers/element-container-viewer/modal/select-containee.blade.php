<div id="{{ $component->getDomId('modal-select-list-containee') }}" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} @if ($component->getModel()->exists()) - {{ $component->getModel()->getTitle() }} @endif <small>{{ $component->translate(sprintf('action.%s', $route_method)) }} "{{ $component->getFormComponent()->getForm()->getContaineeModel()->getModelViewerComponent()->translate('model.title.singular') }}"</small></h4>
            </div>
        {{ Form::open([ 'id' => $component->getDomId('list-containee'), 'url' => $component->getModel()->getControllerRoute('listContainee') ]) }}
            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::hidden('_submit-action', 'submit-show') }}

            <div class="modal-body">
                {!! $component->getFormComponent()->render('include.output') !!}
                {!! $component->getFormComponent()->render('include.fieldset') !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
                <button type="button" class="btn btn-success pull-right" data-ajax-submit-form="{{ $component->getDomIdHash('list-containee') }}"><i class="fa fa-check margin-right-10"></i>{{ $component->translate('button.save') }}</button>
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>