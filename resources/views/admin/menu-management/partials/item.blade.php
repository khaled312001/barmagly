<li class="dd-item" 
    data-id="{{ $item['id'] }}" 
    data-label="{{ $item['label'] }}" 
    data-label-ar="{{ $item['label_ar'] ?? '' }}" 
    data-route="{{ $item['route'] ?? '' }}" 
    data-type="{{ $item['type'] ?? 'link' }}"
    data-visible="{{ ($item['visible'] ?? true) ? 1 : 0 }}">
    
    <div class="dd-handle">
        <span class="label-text">
            @if(isset($item['label_ar']) && $item['label_ar'] != $item['label'])
                <strong>{{ $item['label_ar'] }}</strong> <small class="text-muted">({{ $item['label'] }})</small>
            @else
                <strong>{{ $item['label_ar'] ?? $item['label'] }}</strong>
            @endif
        </span>
        <span class="badge-visibility">
            @if($item['visible'] ?? true)
                <span class="badge bg-success">ظاهر</span>
            @else
                <span class="badge bg-danger">مخفي</span>
            @endif
        </span>
    </div>
    
    <div class="item-actions">
        <button type="button" class="btn btn-primary edit-item"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-danger delete-item"><i class="fas fa-trash"></i></button>
    </div>

    @if(isset($item['children']) && count($item['children']) > 0)
        <ol class="dd-list">
            @foreach($item['children'] as $child)
                @include('admin.menu-management.partials.item', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>
