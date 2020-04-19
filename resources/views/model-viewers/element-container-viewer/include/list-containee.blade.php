<div id="{{ $component->getDomId('list-containee', $component->getModel()->getKey()) }}">
@if ($component->getModel()->hasContainee('items'))
    <ul class="navigation sortable vertical ajax-overlay" data-update-url="{{ $component->getModel()->getControllerRoute('reorder', [ 'relation' => 'items' ]) }}">
    @foreach ($component->getModel()->getContainees('items') as $item)
        <li id="{{ $item->getModelViewerComponent()->getDomId('list-containee', md5(get_class($item)), $item->getKey()) }}" data-containee-id="{{ $item->getKey() }}" data-containee-type="{{ get_class($item) }}">
            <div class="row">
                <div class="col-xs-2 text-left actions">
                    <div class="btn-group">
                        <span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>
                        <a type="button" class="btn btn-primary btn-sm margin-right-no"  title="{{ $component->translate('table-button.edit') }}" href="{{ $item->getControllerRoute('edit') }}" target="_blank"><i class="fa fa-pencil"></i></a>
                        <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $item->getControllerRoute('detach', [ '_section' => 'list-containee', '_data[container_id]' => $component->getModel()->getKey(), '_data[container_type]' => get_class($component->getModel()), '_data[container_relation]' => 'items' ]) }}"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="col-xs-10">
                @if ($item->image && $item->image()->exists())
                    <div class="d-inline-block margin-right-10">
                        <img style="max-width: 128px;" src="{!! asset($item->image->getStoragePath('small-square')) !!}"/>
                    </div>
                @elseif ($item->imagePrimary && $item->imagePrimary()->exists())
                    <div class="d-inline-block margin-right-10">
                        <img style="max-width: 128px;" src="{!! asset($item->imagePrimary->getStoragePath('small-square')) !!}"/>
                    </div>
                @endif
                    <span class="d-inline-block margin-top-5">{!! $item->getTitle() !!}</span>
                </div>
            </div>
        </li>
    @endforeach
    </ul>
@endif
</div>