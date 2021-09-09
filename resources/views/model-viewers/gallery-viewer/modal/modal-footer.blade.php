<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
    <div class="btn-group" role="group">
    @if ($user->can('view', $component->getModel()))
        <a href="" class="btn btn-primary"><i class="fa fa-refresh margin-right-10"></i>{{ $component->translate('button.submit-reload') }}</a>
    @endif
    </div>
</div>