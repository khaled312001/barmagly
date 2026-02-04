@extends('admin.master_layout')
@section('title')
    <title>{{ __('translate.Menu Management') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Menu Management') }} / إدارة القوائم</h3>
    <p class="crancy-header__text">{{ __('translate.Manage Content') }} >> {{ __('translate.Menu Management') }}</p>
@endsection

@section('body-content')
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <div class="crancy-dsinner">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card crancy-card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="card-title mb-0">{{ __('translate.Menu Structure') }} / هيكل القائمة</h5>
                                                <small class="text-muted">{{ __('translate.Drag each item to the order you prefer.') }} / اسحب كل عنصر للترتيب الذي تفضله.</small>
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm" id="addItemBtn">
                                                <i class="fas fa-plus"></i> {{ __('translate.Add New Item') }} / إضافة عنصر جديد
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="dd" id="nestable">
                                                <ol class="dd-list">
                                                    @foreach($menuItems as $item)
                                                        @include('admin.menu-management.partials.item', ['item' => $item])
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <form action="{{ route('admin.menu-management.update') }}" method="POST" id="saveMenuForm">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="menu_data" id="nestable-output">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="fas fa-save"></i> {{ __('translate.Save Changes') }} / حفظ التغييرات
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card crancy-card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">{{ __('translate.Helpful Information') }} / معلومات مفيدة</h5>
                                        </div>
                                        <div class="card-body">
                                            <h6>{{ __('translate.Common Routes') }} / الروابط الشائعة</h6>
                                            <ul class="list-group list-group-flush mt-2">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Home / الرئيسية <span><code>home</code></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Services / الخدمات <span><code>services</code></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Blog / المدونة <span><code>blogs</code></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Portfolio / أعمالنا <span><code>portfolio</code></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    About Us / من نحن <span><code>about-us</code></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Contact / اتصل بنا <span><code>contact-us</code></span>
                                                </li>
                                            </ul>
                                            <div class="alert alert-info mt-3">
                                                <p class="mb-0"><small><i class="fas fa-info-circle"></i> {{ __('translate.Use "dropdown" type for submenus.') }} / استخدم نوع "dropdown" للقوائم الفرعية.</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Add/Edit Item -->
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">{{ __('translate.Edit Menu Item') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="itemForm">
                        <input type="hidden" id="edit-id">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label"><strong>{{ __('translate.Label (English)') }}</strong> / الاسم (إنجليزي) <span class="text-danger">*</span></label>
                                <input type="text" id="edit-label" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label"><strong>{{ __('translate.Label (Arabic)') }}</strong> / الاسم (عربي)</label>
                                <input type="text" id="edit-label-ar" class="form-control">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('translate.Route') }} / الرابط</label>
                                <input type="text" id="edit-route" class="form-control" placeholder="e.g., home">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('translate.Type') }} / النوع</label>
                                <select id="edit-type" class="form-control">
                                    <option value="link">{{ __('translate.Link') }} / رابط</option>
                                    <option value="dropdown">{{ __('translate.Dropdown') }} / قائمة منسدلة</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input type="checkbox" id="edit-visible" class="form-check-input" value="1" checked>
                                    <label class="form-check-label">{{ __('translate.Visible') }} / ظاهر</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" id="modalDeleteItemBtn">
                        <i class="fas fa-trash"></i> {{ __('translate.Delete Item') }} / حذف العنصر
                    </button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('translate.Close') }} / إغلاق</button>
                        <button type="button" class="btn btn-primary" id="saveItemBtn">{{ __('translate.Update Item') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('style_section')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">
    <style>
        .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
        .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
        .dd-list .dd-list { padding-left: 30px; }
        .dd-collapsed .dd-list { display: none; }
        .dd-item, .dd-empty, .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
        .dd-handle { 
            display: block; height: 50px; margin: 5px 0; padding: 14px 25px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc; 
            background: #fafafa; border-radius: 3px; box-sizing: border-box; -moz-box-sizing: border-box; cursor: move;
        }
        .dd-handle:hover { color: #2ea8e5; background: #fff; }
        .dd-item > button { 
            display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 15px 0; padding: 0; text-indent: 100%; 
            white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; 
        }
        .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-indent: 0; }
        .dd-item > button[data-action="collapse"]:before { content: '-'; }
        .dd-placeholder, .dd-empty { margin: 5px 0; padding: 0; min-height: 50px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
        .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5; background-size: 60px 60px; background-position: 0 0, 30px 30px; }
        .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
        .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
        .dd-dragel .dd-handle { -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1); box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1); }
        .item-actions { position: absolute; right: 10px; top: 12px; }
        .item-actions .btn { padding: 2px 8px; font-size: 12px; }
        .dd-handle .label-text { display: inline-block; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .dd-handle .badge { margin-left: 10px; font-weight: normal; }
    </style>
    @endpush

    @push('js_section')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
    <script>
        $(document).ready(function() {
            var $nestable = $('#nestable').nestable({
                group: 1,
                maxDepth: 3,
                callback: function(l, e) {
                    updateOutput();
                }
            });

            var updateOutput = function() {
                var json = window.JSON.stringify($nestable.nestable('serialize'));
                $('#nestable-output').val(json);
            };

            updateOutput();

            // Edit Item
            $(document).on('click', '.edit-item', function() {
                var data = $(this).closest('.dd-item').data();
                $('#edit-id').val(data.id);
                $('#edit-label').val(data.label);
                $('#edit-label-ar').val(data.labelAr);
                $('#edit-route').val(data.route);
                $('#edit-type').val(data.type);
                $('#edit-visible').prop('checked', data.visible == 1);
                
                $('#itemModalLabel').text('{{ __("translate.Edit Menu Item") }} / تعديل عنصر القائمة');
                $('#saveItemBtn').text('{{ __("translate.Update Item") }} / تحديث العنصر').removeClass('btn-success').addClass('btn-primary');
                $('#modalDeleteItemBtn').show();
                $('#itemModal').modal('show');
            });

            // Add Item Trigger
            $('#addItemBtn').on('click', function() {
                $('#itemForm')[0].reset();
                $('#edit-id').val('new_' + Date.now());
                $('#itemModalLabel').text('{{ __("translate.Add Menu Item") }} / إضافة عنصر للقائمة');
                $('#saveItemBtn').text('{{ __("translate.Add Item") }} / إضافة العنصر').removeClass('btn-primary').addClass('btn-success');
                $('#edit-visible').prop('checked', true);
                $('#modalDeleteItemBtn').hide();
                $('#itemModal').modal('show');
            });

            // Save/Update Item
            $('#saveItemBtn').on('click', function() {
                var id = $('#edit-id').val();
                var label = $('#edit-label').val();
                var labelAr = $('#edit-label-ar').val();
                var route = $('#edit-route').val();
                var type = $('#edit-type').val();
                var visible = $('#edit-visible').is(':checked') ? 1 : 0;

                if (!label) {
                    toastr.error('Label is required / العنوان مطلوب');
                    return;
                }

                var $item = $('li.dd-item[data-id="' + id + '"]');
                
                if ($item.length > 0) {
                    // Update existing
                    $item.data('label', label);
                    $item.data('label-ar', labelAr);
                    $item.data('route', route);
                    $item.data('type', type);
                    $item.data('visible', visible);
                    
                    $item.find('> .dd-handle .label-text').html(`<strong>${label}</strong> / ${labelAr || '---'}`);
                    $item.find('> .dd-handle .badge-visibility').html(visible == 1 ? '<span class="badge bg-success">Visible / ظاهر</span>' : '<span class="badge bg-danger">Hidden / مخفي</span>');
                } else {
                    // Add new
                    var newItemHtml = `
                        <li class="dd-item" data-id="${id}" data-label="${label}" data-label-ar="${labelAr}" data-route="${route}" data-type="${type}" data-visible="${visible}">
                            <div class="dd-handle">
                                <span class="label-text"><strong>${label}</strong> / ${labelAr || '---'}</span>
                                <span class="badge-visibility">${visible == 1 ? '<span class="badge bg-success">Visible / ظاهر</span>' : '<span class="badge bg-danger">Hidden / مخفي</span>'}</span>
                            </div>
                            <div class="item-actions">
                                <button type="button" class="btn btn-primary edit-item"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger delete-item"><i class="fas fa-trash"></i></button>
                            </div>
                        </li>`;
                    
                    if ($('#nestable > .dd-list').length === 0) {
                        $('#nestable').append('<ol class="dd-list"></ol>');
                    }
                    $('#nestable > .dd-list').append(newItemHtml);
                }

                updateOutput();
                $('#itemModal').modal('hide');
            });

            // Delete Item
            $(document).on('click', '.delete-item', function() {
                if (confirm('Are you sure you want to delete this item? / هل أنت متأكد من حذف هذا العنصر؟')) {
                    $(this).closest('.dd-item').remove();
                    updateOutput();
                }
            });

            // Delete from Modal
            $('#modalDeleteItemBtn').on('click', function() {
                var id = $('#edit-id').val();
                if (confirm('Are you sure you want to delete this item? / هل أنت متأكد من حذف هذا العنصر؟')) {
                    $('li.dd-item[data-id="' + id + '"]').remove();
                    updateOutput();
                    $('#itemModal').modal('hide');
                }
            });

            // Submit Form
            $('#saveMenuForm').on('submit', function() {
                updateOutput();
            });
        });
    </script>
    @endpush
@endsection

