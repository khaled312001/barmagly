@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Menu Management') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Menu Management') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Manage Content') }} >> {{ __('translate.Menu Management') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="crancy-table crancy-table--v3 mg-top-30">
                                <form action="{{ route('admin.menu-management.update') }}" method="POST" id="menuForm">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">{{ __('translate.Menu Items') }}</h5>
                                            <p class="text-muted mb-0">{{ __('translate.Drag and drop to reorder, toggle visibility, and edit menu items') }}</p>
                                        </div>
                                        <div class="card-body">
                                            <div id="menuItemsList" class="menu-items-list">
                                                @foreach($menuItems as $index => $item)
                                                    <div class="menu-item-card mb-3" data-item-id="{{ $item['id'] }}">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-1">
                                                                        <i class="fas fa-grip-vertical text-muted drag-handle" style="cursor: move; font-size: 20px;"></i>
                                                                        <input type="hidden" name="menu_items[{{ $index }}][order]" value="{{ $item['order'] ?? $index + 1 }}" class="item-order">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">{{ __('translate.Label (English)') }}</label>
                                                                        <input type="text" name="menu_items[{{ $index }}][label]" value="{{ $item['label'] ?? '' }}" class="form-control" required>
                                                                        <input type="hidden" name="menu_items[{{ $index }}][id]" value="{{ $item['id'] }}">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">{{ __('translate.Label (Arabic)') }}</label>
                                                                        <input type="text" name="menu_items[{{ $index }}][label_ar]" value="{{ $item['label_ar'] ?? '' }}" class="form-control">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label class="form-label">{{ __('translate.Route') }}</label>
                                                                        <input type="text" name="menu_items[{{ $index }}][route]" value="{{ $item['route'] ?? '' }}" class="form-control" placeholder="e.g., home, services">
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label class="form-label">{{ __('translate.Type') }}</label>
                                                                        <select name="menu_items[{{ $index }}][type]" class="form-control">
                                                                            <option value="link" {{ ($item['type'] ?? 'link') == 'link' ? 'selected' : '' }}>{{ __('translate.Link') }}</option>
                                                                            <option value="dropdown" {{ ($item['type'] ?? 'link') == 'dropdown' ? 'selected' : '' }}>{{ __('translate.Dropdown') }}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label class="form-label">{{ __('translate.Visible') }}</label>
                                                                        <div class="form-check form-switch">
                                                                            <input type="hidden" name="menu_items[{{ $index }}][visible]" value="0">
                                                                            <input type="checkbox" name="menu_items[{{ $index }}][visible]" value="1" class="form-check-input" {{ ($item['visible'] ?? true) ? 'checked' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                @if(isset($item['children']) && is_array($item['children']))
                                                                    <div class="mt-3 ms-4">
                                                                        <h6 class="mb-2">{{ __('translate.Sub Items') }}:</h6>
                                                                        @foreach($item['children'] as $childIndex => $child)
                                                                            <div class="row mb-2 align-items-center">
                                                                                <div class="col-md-4">
                                                                                    <input type="text" name="menu_items[{{ $index }}][children][{{ $childIndex }}][label]" value="{{ $child['label'] ?? '' }}" class="form-control form-control-sm" placeholder="{{ __('translate.Label (English)') }}">
                                                                                    <input type="hidden" name="menu_items[{{ $index }}][children][{{ $childIndex }}][id]" value="{{ $child['id'] }}">
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <input type="text" name="menu_items[{{ $index }}][children][{{ $childIndex }}][label_ar]" value="{{ $child['label_ar'] ?? '' }}" class="form-control form-control-sm" placeholder="{{ __('translate.Label (Arabic)') }}">
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <input type="text" name="menu_items[{{ $index }}][children][{{ $childIndex }}][route]" value="{{ $child['route'] ?? '' }}" class="form-control form-control-sm" placeholder="{{ __('translate.Route') }}">
                                                                                </div>
                                                                                <div class="col-md-1">
                                                                                    <div class="form-check form-switch">
                                                                                        <input type="hidden" name="menu_items[{{ $index }}][children][{{ $childIndex }}][visible]" value="0">
                                                                                        <input type="checkbox" name="menu_items[{{ $index }}][children][{{ $childIndex }}][visible]" value="1" class="form-check-input" {{ ($child['visible'] ?? true) ? 'checked' : '' }}>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> {{ __('translate.Save Changes') }}
                                            </button>
                                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                                {{ __('translate.Cancel') }}
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('style_section')
    <style>
        .menu-items-list {
            min-height: 200px;
        }
        .menu-item-card {
            cursor: move;
        }
        .menu-item-card.ui-sortable-helper {
            opacity: 0.8;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .drag-handle {
            cursor: move;
        }
        .menu-item-card:hover {
            background-color: #f8f9fa;
        }
    </style>
    @endpush

    @push('script_section')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            // Make menu items sortable
            $("#menuItemsList").sortable({
                handle: '.drag-handle',
                axis: 'y',
                update: function(event, ui) {
                    // Update order values
                    $('#menuItemsList .menu-item-card').each(function(index) {
                        $(this).find('.item-order').val(index + 1);
                    });
                }
            });

            // Handle form submission
            $('#menuForm').on('submit', function(e) {
                // Ensure all order values are updated
                $('#menuItemsList .menu-item-card').each(function(index) {
                    $(this).find('.item-order').val(index + 1);
                });
            });
        });
    </script>
    @endpush
@endsection

