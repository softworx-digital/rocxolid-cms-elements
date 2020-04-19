<div id="{{ $component->getDomId('select-page-element-class') }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} @if ($component->getModel()->exists()) - {{ $component->getModel()->getTitle() }} @endif <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
            @foreach ($component->getModel()->getPageElementModels() as $short_class => $model)
                <div class="row">
                    <div class="col-xs-12">
                        <a class="btn btn-default col-xs-12" data-dismiss="modal" data-ajax-url="{{ $model->getControllerRoute($page_element_class_action, ['_section' => 'page-elements', '_data[page_template_id]' => $component->getModel()->getKey()]) }}">{{ __(sprintf('rocXolid::%s.model.title.singular', $short_class)) }}</a>
                    </div>
                </div>
            @endforeach
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            </div>
        </div>
    </div>
</div>