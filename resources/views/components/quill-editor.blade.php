@props([
    'name' => 'content',
    'value' => '',
    'placeholder' => 'İçeriğinizi yazın...',
    'height' => '300px',
    'toolbar' => 'full',
    'theme' => 'snow',
    'required' => false,
    'class' => ''
])

<div class="quill-editor-wrapper {{ $class }}"
     x-data="quillEditor({
         name: '{{ $name }}',
         value: @js($value),
         placeholder: '{{ $placeholder }}',
         height: '{{ $height }}',
         toolbar: '{{ $toolbar }}',
         theme: '{{ $theme }}',
         required: {{ $required ? 'true' : 'false' }}
     })"
     x-init="config = {
         name: '{{ $name }}',
         value: @js($value),
         placeholder: '{{ $placeholder }}',
         height: '{{ $height }}',
         toolbar: '{{ $toolbar }}',
         theme: '{{ $theme }}',
         required: {{ $required ? 'true' : 'false' }}
     }">

    <!-- Quill Editor Container -->
    <div x-ref="quillContainer"
         class="quill-container border border-gray-300 rounded-md overflow-hidden"
         style="height: {{ $height }};">
    </div>

    <!-- Hidden Input for Form Submission -->
    <input type="hidden"
           name="{{ $name }}"
           value="{{ $value }}"
           x-ref="hiddenInput">

    <!-- Character Count -->
    <div class="mt-2 flex justify-between items-center text-xs text-gray-500">
        <span x-text="characterCount + ' karakter'"></span>
        <span x-show="isValid" class="text-green-600">✓ Geçerli</span>
        <span x-show="!isValid && content.length > 0" class="text-red-600">⚠ İçerik gerekli</span>
    </div>

    <!-- Error Message -->
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<style>
    .quill-container .ql-editor {
        min-height: {{ $height }};
        font-family: inherit;
        font-size: 14px;
        line-height: 1.5;
    }

    .quill-container .ql-toolbar {
        border-top: 1px solid #d1d5db;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
        border-bottom: none;
    }

    .quill-container .ql-container {
        border-bottom: 1px solid #d1d5db;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
        border-top: none;
    }

    .quill-container .ql-editor.ql-blank::before {
        color: #9ca3af;
        font-style: normal;
    }

    .quill-container .ql-toolbar .ql-stroke {
        stroke: #374151;
    }

    .quill-container .ql-toolbar .ql-fill {
        fill: #374151;
    }

    .quill-container .ql-toolbar button:hover .ql-stroke {
        stroke: #f97316;
    }

    .quill-container .ql-toolbar button:hover .ql-fill {
        fill: #f97316;
    }

    .quill-container .ql-toolbar button.ql-active .ql-stroke {
        stroke: #f97316;
    }

    .quill-container .ql-toolbar button.ql-active .ql-fill {
        fill: #f97316;
    }
</style>
