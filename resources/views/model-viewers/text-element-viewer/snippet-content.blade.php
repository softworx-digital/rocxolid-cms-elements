@if (filled($component->getModel()->content))
@if (false)
@foreach (collect(json_decode($component->getModel()->content, true)) as $text)
    {!! $text !!}
@endforeach
@endif
{!! $component->getModel()->content !!}
@else
{{ Faker\Factory::create('en_US')->realText() }}
@endif
