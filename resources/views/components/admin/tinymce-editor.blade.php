@props([
    'id' => 'editor',
    'name' => 'content',
    'value' => '',
    'label' => 'Konten',
    'required' => false,
    'error' => null,
    'height' => 500,
    'placeholder' => 'Tulis konten di sini...'
])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        class="tinymce-editor @error($name) border-red-500 @enderror"
        data-height="{{ $height }}"
        placeholder="{{ $placeholder }}"
    >{{ old($name, $value) }}</textarea>

    @if($error || $errors->has($name))
        <p class="mt-2 text-sm text-red-600">{{ $error ?? $errors->first($name) }}</p>
    @endif
</div>

@once
    @push('styles')
    <style>
        .tox-tinymce {
            border-radius: 0.375rem !important;
            border-color: #d1d5db !important;
        }

        .tox-statusbar {
            border-top: 1px solid #e5e7eb !important;
        }

        .tox-toolbar {
            background: #f9fafb !important;
        }

        .tox .tox-toolbar__primary {
            background: #f9fafb !important;
        }
    </style>
    @endpush

    @push('scripts')
    <!-- TinyMCE CDN (Free - No API Key Required) -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all TinyMCE editors
            const editors = document.querySelectorAll('.tinymce-editor');

            editors.forEach(function(editor) {
                const height = editor.dataset.height || 500;

                tinymce.init({
                    target: editor,
                    height: height,
                    menubar: 'file edit view insert format tools table help',

                    // Plugins - Optimized for free version
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'help', 'wordcount'
                    ],

                    // Toolbar - Better organized and functional
                    toolbar1: 'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor backcolor',
                    toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat code fullscreen help',

                    // Toolbar mode
                    toolbar_mode: 'sliding',

                    // Quick toolbar for selections
                    quickbars_selection_toolbar: 'bold italic | forecolor backcolor | alignleft aligncenter alignright | link',
                    quickbars_insert_toolbar: false,

                    // Content CSS
                    content_css: false,

                    // Format options - More control
                    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre; Blockquote=blockquote',

                    // Font size options
                    fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',

                    // Font family options
                    font_formats: 'Arial=arial,helvetica,sans-serif; ' +
                        'Arial Black=arial black,avant garde; ' +
                        'Comic Sans MS=comic sans ms,sans-serif; ' +
                        'Courier New=courier new,courier; ' +
                        'Georgia=georgia,palatino; ' +
                        'Impact=impact,chicago; ' +
                        'Tahoma=tahoma,arial,helvetica,sans-serif; ' +
                        'Times New Roman=times new roman,times; ' +
                        'Verdana=verdana,geneva',

                    // Line height options
                    lineheight_formats: '1 1.15 1.2 1.5 1.75 2 2.5 3',

                    // Content style - Proper formatting
                    content_style: `
                        body {
                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                            font-size: 16px;
                            line-height: 1.6;
                            color: #374151;
                            padding: 1rem;
                            margin: 0;
                        }

                        * {
                            box-sizing: border-box;
                        }

                        h1, h2, h3, h4, h5, h6 {
                            color: #1f2937;
                            font-weight: 600;
                            margin-top: 1.5rem;
                            margin-bottom: 0.75rem;
                            line-height: 1.3;
                        }

                        h1 { font-size: 2.25rem; }
                        h2 { font-size: 1.875rem; }
                        h3 { font-size: 1.5rem; }
                        h4 { font-size: 1.25rem; }
                        h5 { font-size: 1.125rem; }
                        h6 { font-size: 1rem; }

                        p {
                            margin-bottom: 1rem;
                            margin-top: 0;
                        }

                        /* Text alignment styles */
                        .mce-content-body[data-mce-selected] {
                            outline: none;
                        }

                        p[style*="text-align: center"],
                        h1[style*="text-align: center"],
                        h2[style*="text-align: center"],
                        h3[style*="text-align: center"],
                        h4[style*="text-align: center"],
                        h5[style*="text-align: center"],
                        h6[style*="text-align: center"] {
                            text-align: center !important;
                        }

                        p[style*="text-align: right"],
                        h1[style*="text-align: right"],
                        h2[style*="text-align: right"],
                        h3[style*="text-align: right"],
                        h4[style*="text-align: right"],
                        h5[style*="text-align: right"],
                        h6[style*="text-align: right"] {
                            text-align: right !important;
                        }

                        p[style*="text-align: justify"],
                        h1[style*="text-align: justify"],
                        h2[style*="text-align: justify"],
                        h3[style*="text-align: justify"],
                        h4[style*="text-align: justify"],
                        h5[style*="text-align: justify"],
                        h6[style*="text-align: justify"] {
                            text-align: justify !important;
                        }

                        a {
                            color: #2563eb;
                            text-decoration: underline;
                        }

                        a:hover {
                            color: #1d4ed8;
                        }

                        ul, ol {
                            padding-left: 2rem;
                            margin-bottom: 1rem;
                            margin-top: 0;
                        }

                        li {
                            margin-bottom: 0.5rem;
                        }

                        blockquote {
                            border-left: 4px solid #e5e7eb;
                            padding-left: 1rem;
                            margin: 1rem 0;
                            color: #6b7280;
                            font-style: italic;
                        }

                        code {
                            background-color: #f3f4f6;
                            padding: 0.125rem 0.25rem;
                            border-radius: 0.25rem;
                            font-family: 'Courier New', Courier, monospace;
                            font-size: 0.875rem;
                        }

                        pre {
                            background-color: #1f2937;
                            color: #f9fafb;
                            padding: 1rem;
                            border-radius: 0.375rem;
                            overflow-x: auto;
                            margin-bottom: 1rem;
                        }

                        pre code {
                            background: transparent;
                            color: inherit;
                            padding: 0;
                        }

                        table {
                            border-collapse: collapse;
                            width: 100%;
                            margin-bottom: 1rem;
                        }

                        table th,
                        table td {
                            border: 1px solid #e5e7eb;
                            padding: 0.75rem;
                            text-align: left;
                        }

                        table th {
                            background-color: #f9fafb;
                            font-weight: 600;
                        }

                        img {
                            max-width: 100%;
                            height: auto;
                            border-radius: 0.375rem;
                            display: block;
                        }

                        /* Better spacing */
                        .mce-content-body > *:first-child {
                            margin-top: 0;
                        }

                        .mce-content-body > *:last-child {
                            margin-bottom: 0;
                        }
                    `,

                    // Image upload settings - Base64 for simplicity
                    images_upload_handler: function (blobInfo, success, failure) {
                        const reader = new FileReader();
                        reader.onload = function() {
                            success(reader.result);
                        };
                        reader.onerror = function() {
                            failure('Gagal mengupload gambar');
                        };
                        reader.readAsDataURL(blobInfo.blob());
                    },

                    // File picker settings
                    file_picker_types: 'image',
                    file_picker_callback: function(callback, value, meta) {
                        if (meta.filetype === 'image') {
                            const input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');

                            input.onchange = function() {
                                const file = this.files[0];
                                const reader = new FileReader();

                                reader.onload = function() {
                                    callback(reader.result, {
                                        alt: file.name
                                    });
                                };

                                reader.readAsDataURL(file);
                            };

                            input.click();
                        }
                    },

                    // Image options
                    image_caption: true,
                    image_advtab: true,
                    image_title: true,

                    // Link options
                    link_default_target: '_blank',
                    link_assume_external_targets: true,
                    link_title: false,
                    default_link_target: '_blank',
                    target_list: [
                        {text: 'New window', value: '_blank'},
                        {text: 'Same window', value: '_self'}
                    ],

                    // Table options
                    table_default_attributes: {
                        border: '1'
                    },
                    table_default_styles: {
                        'border-collapse': 'collapse',
                        'width': '100%'
                    },
                    table_responsive_width: true,
                    table_class_list: [
                        {title: 'Default', value: ''},
                        {title: 'Bordered', value: 'table-bordered'},
                        {title: 'Striped', value: 'table-striped'}
                    ],

                    // Paste options - Clean paste
                    paste_as_text: false,
                    paste_data_images: true,
                    paste_preprocess: function(plugin, args) {
                        // Clean up pasted content
                        args.content = args.content.replace(/font-family:[^;]+;/gi, '');
                    },

                    // Smart paste from Word
                    paste_word_valid_elements: 'b,strong,i,em,h1,h2,h3,h4,h5,h6,p,ul,ol,li,a[href],span,br',

                    // Content filtering
                    valid_elements: '*[*]',
                    extended_valid_elements: 'script[src|async|defer|type|charset]',

                    // Other important settings
                    automatic_uploads: true,
                    elementpath: true,
                    resize: true,
                    statusbar: true,
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls: true,

                    // Responsive
                    mobile: {
                        menubar: true,
                        toolbar_mode: 'sliding',
                        toolbar_sticky: true
                    },

                    // Browser spellcheck
                    browser_spellcheck: true,

                    // Context menu
                    contextmenu: 'link image table',

                    // Setup callback with better handling
                    setup: function(editor) {
                        // Initialize
                        editor.on('init', function() {
                            console.log('✓ TinyMCE Editor ready:', editor.id);
                        });

                        // Better Enter key handling
                        editor.on('keydown', function(e) {
                            // Ctrl+Enter to submit form
                            if (e.keyCode === 13 && e.ctrlKey) {
                                const form = editor.getElement().closest('form');
                                if (form) {
                                    form.submit();
                                }
                            }
                        });

                        // Prevent alignment issues
                        editor.on('NodeChange', function(e) {
                            // Ensure proper paragraph formatting
                            if (e.element.nodeName === 'P' && !e.element.style.textAlign) {
                                // Default alignment
                            }
                        });

                        // Before content is set
                        editor.on('BeforeSetContent', function(e) {
                            // Clean content before setting
                            if (e.content) {
                                // Remove empty paragraphs
                                e.content = e.content.replace(/<p>(&nbsp;|\s)*<\/p>/gi, '');
                            }
                        });
                    }
                });
            });

            // Clean up on page unload
            window.addEventListener('beforeunload', function() {
                if (typeof tinymce !== 'undefined') {
                    tinymce.remove();
                }
            });
        });
    </script>
    @endpush
@endonce
