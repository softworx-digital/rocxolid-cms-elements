@if ($component->getModel() instanceof \Softworx\RocXolid\Models\Contracts\Containee)
<li data-page-element-id="{{ $component->getModel()->getKey() }}" data-page-element-type="{{ get_class($component->getModel()) }}" data-containee-id="{{ $component->getModel()->getKey() }}" data-containee-type="{{ get_class($component->getModel()) }}"@isset($component->getModel()->name) title="{{ $component->getModel()->name }}"@endif>
@else
<li data-page-element-id="{{ $component->getModel()->getKey() }}" data-page-element-type="{{ get_class($component->getModel()) }}"@isset($component->getModel()->name) title="{{ $component->getModel()->name }}"@endif>
@endif
    <div class="block">
        <div class="tags">
            <a class="tag"><span>{{ $component->translate('model.title.singular') }}</span></a>
        </div>
        <div class="block_content">
            <div class="row">
            @foreach ($component->getModel()->getShowAttributes([ 'id', 'name' ]) as $field => $value)
                @if ($field == 'iframe')
                    <div class="col-xs-9">
                        <label class="col-xs-2 text-right">{{ $component->translate(sprintf('field.%s', $field)) }}</label>
                        <div class="col-xs-10"><div style="width: 320px; height: 180px;">{!! $component->getModel()->$field !!}</div></div>
                    </div>
                @elseif (strip_tags($component->getModel()->$field) !== '')
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <label class="col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $field)) }}</label>
                        <div class="col-xs-6">{!! Str::limit(strip_tags($component->getModel()->$field), 120, ' (...)') !!}</div>
                    </div>
                @endif
            @endforeach
            </div>
            <div class="row">
            @foreach ($component->getModel()->getRelationshipMethods('web') as $method)
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <label class="col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $method)) }}</label>
                    <div class="col-xs-6">
                    @foreach ($component->getModel()->$method()->get() as $item)
                        {{-- @todo: revise --}}
                        @can ('update', $item)
                            <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
                        @else
                            <span class="label label-info">{{ $item->getTitle() }}</span>
                        @endif
                    @endforeach
                    </div>
                </div>
            @endforeach
            </div>
        {{-- @todo: ugly --}}
        @if (($component->getModel() instanceof \Softworx\RocXolid\Models\Contracts\Container) && $component->getModel()->hasContainee('items'))
            @if (!method_exists($component->getModel(), 'isManualContainerFillType') || $component->getModel()->isManualContainerFillType())
                <div class="row">
                    <div class="col-xs-12">
                        <h4>{{ $component->translate('text.assigned-models') }}</h4>
                        <div class="well">
                            <div class="row">
                            @foreach ($component->getModel()->getContainees('items') as $item)
                                {!! $item->getModelViewerComponent()->render('in-container') !!}
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        </div>
        <div class="actions text-center">
            <div class="btn-group">
                <span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>
            {{-- @todo: ugly --}}
            @if (($component->getModel() instanceof \Softworx\RocXolid\Models\Contracts\Container) && !($component->getModel() instanceof \Softworx\RocXolid\CMS\Models\HtmlWrapper))
                @if (!method_exists($component->getModel(), 'isManualContainerFillType') || $component->getModel()->isManualContainerFillType())
                    <a type="button" class="btn btn-success btn-sm margin-right-no" title="{{ $component->translate('table-button.compose') }}" href="{{ $component->getModel()->getControllerRoute('show') }}" target="_blank"><i class="fa fa-object-group"></i></a>
                @endif
            @endif
            @if (isset($container))
                @if (false)
                    <a type="button" class="btn btn-primary btn-sm margin-right-no" title="{{ $component->translate('table-button.edit') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', [ '_section' => 'page-elements', '_data[container_id]' => $container->getKey(), '_data[container_type]' => get_class($container), '_data[container_relation]' => $page_elementable->getCCRelationParam() ]) }}"><i class="fa fa-pencil"></i></a>
                    <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('detach', [ '_section' => 'page-elements', '_data[container_id]' => $container->getKey(), '_data[container_type]' => get_class($container), '_data[container_relation]' => $page_elementable->getCCRelationParam() ]) }}"><i class="fa fa-minus"></i></a>
                @endif
            @else
                <a type="button" class="btn btn-primary btn-sm margin-right-no" title="{{ $component->translate('table-button.edit') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', ['_section' => 'page-elements', $page_elementable->getRequestFieldName() => $page_elementable->getKey()]) }}"><i class="fa fa-pencil"></i></a>
                <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('detach', ['_section' => 'page-elements', $page_elementable->getRequestFieldName() => $page_elementable->getKey()]) }}"><i class="fa fa-minus"></i></a>

                {{-- @todo: ugly --}}
                {{ Form::open([ 'id' => $component->getDomId('pivot-data', md5(sprintf('%s-%s', get_class($component->getModel()), $component->getModel()->getKey()))), 'class' => 'autosubmit ajax-overlay', 'url' => $page_elementable->getControllerRoute('setPivotData', [ 'page_elementable_type' => get_class($component->getModel()), 'page_elementable_id' => $component->getModel()->getKey() ]) ]) }}
                    @foreach ($component->getModel()->getPivotData() as $pivot_data => $value)
                        @if (substr($pivot_data, 0, 3) == 'is_')
                            <label class="margin-top-5 margin-bottom-no">{{ $component->getModel()->getParentPageElementable()->getModelViewerComponent()->translate(sprintf('field.pivot-%s', $pivot_data)) }}<i class="fa fa-question-circle text-warning margin-left-5" title="{{ $component->getModel()->getParentPageElementable()->getModelViewerComponent()->translate(sprintf('hint.%s', $pivot_data)) }}"></i></label>
                            <label class="margin-top-5 margin-bottom-no">
                                {{ Form::hidden(sprintf('_data[%s]', $pivot_data), 0) }}
                                <input type="checkbox" class="autosubmit" data-toggle="toggle" data-size="small" data-width="95" data-onstyle="success" @if ($value) checked="checked" @endif name="_data[{{ $pivot_data }}]" value="1"/>
                            </label>
                        @endif
                        @if ($component->getModel()->getParentPageElementable()->isPageElementTemplateChoiceEnabled() && ($pivot_data == 'template'))
                        <div class="form-group margin-top-no">
                            {!! Form::select(sprintf('_data[%s]', $pivot_data), $component->getModel()->getTemplateOptions(), $value, [ 'class' => 'col-xs-12 autosubmit' ]) !!}
                        </div>
                        @endif
                    @endforeach
                        <button type="button" class="hidden" data-ajax-submit-form="{{ $component->getDomIdHash('pivot-data', md5(sprintf('%s-%s', get_class($component->getModel()), $component->getModel()->getKey()))) }}"><i class="fa fa-search"></i></button>
                {{ Form::close() }}
            @endif
            </div>
        </div>
    </div>
@if (false)
@if ($component->getModel() instanceof \Softworx\RocXolid\Models\Contracts\Container)
    <ul class="list-inline containee-only">
    @foreach ($component->getModel()->getContainees($page_elementable->getCCRelationParam()) as $item)
        {!! $item->getModelViewerComponent()->render('in-page-elementable', [ 'page_elementable' => $page_elementable, 'container' => $component->getModel() ]) !!}
    @endforeach
    </ul>
@endif
@endif
@if ($component->getModel() instanceof \Softworx\RocXolid\CMS\Models\HtmlWrapper)
    <ul class="sortable margin-top-5 containee-only @if ($component->getModel()->getContainees('items')->isEmpty()) empty @endif">
    @foreach ($component->getModel()->getContainees($page_elementable->getCCRelationParam()) as $item)
        {!! $item->getModelViewerComponent()->render('in-page-elementable', [ 'page_elementable' => $page_elementable, 'container' => $component->getModel() ]) !!}
    @endforeach
    </ul>
@endif
</li>