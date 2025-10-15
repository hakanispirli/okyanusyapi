{{-- SEO Content Section --}}
@if($service->seo_content)
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="quill-content prose prose-lg max-w-none">
                {!! $service->sanitized_seo_content !!}
            </div>
        </div>
    </section>
@endif

<style>
/* Quill Editor Content Styles */
.quill-content {
    color: #374151;
    line-height: 1.7;
}

.quill-content h1,
.quill-content h2,
.quill-content h3,
.quill-content h4,
.quill-content h5,
.quill-content h6 {
    color: #1f2937;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.quill-content h1 {
    font-size: 2.25rem;
    font-weight: 700;
}

.quill-content h2 {
    font-size: 1.875rem;
    font-weight: 700;
}

.quill-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
}

.quill-content h4 {
    font-size: 1.25rem;
    font-weight: 600;
}

.quill-content h5 {
    font-size: 1.125rem;
    font-weight: 600;
}

.quill-content h6 {
    font-size: 1rem;
    font-weight: 600;
}

.quill-content p {
    margin-bottom: 1rem;
    color: #6b7280;
}

.quill-content ul,
.quill-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.quill-content li {
    margin-bottom: 0.5rem;
    color: #6b7280;
}

.quill-content blockquote {
    border-left: 4px solid #f97316;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
    background-color: #f9fafb;
    padding: 1rem;
    border-radius: 0.375rem;
}

.quill-content a {
    color: #f97316;
    text-decoration: underline;
    font-weight: 500;
}

.quill-content a:hover {
    color: #ea580c;
}

.quill-content strong,
.quill-content b {
    font-weight: 600;
    color: #1f2937;
}

.quill-content em,
.quill-content i {
    font-style: italic;
}

.quill-content u {
    text-decoration: underline;
}

.quill-content s {
    text-decoration: line-through;
}

.quill-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    background-color: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

.quill-content th,
.quill-content td {
    padding: 0.75rem 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.quill-content th {
    background-color: #f9fafb;
    font-weight: 600;
    color: #1f2937;
}

.quill-content tr:hover {
    background-color: #f9fafb;
}

.quill-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.quill-content code {
    background-color: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    color: #dc2626;
}

.quill-content pre {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1rem 0;
}

.quill-content pre code {
    background-color: transparent;
    color: inherit;
    padding: 0;
}

.quill-content .ql-align-center {
    text-align: center;
}

.quill-content .ql-align-right {
    text-align: right;
}

.quill-content .ql-align-justify {
    text-align: justify;
}

.quill-content .ql-indent-1 {
    padding-left: 2rem;
}

.quill-content .ql-indent-2 {
    padding-left: 4rem;
}

.quill-content .ql-indent-3 {
    padding-left: 6rem;
}

/* Quill Editor specific classes */
.quill-content .ql-syntax {
    background-color: #1f2937;
    color: #f9fafb;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1rem 0;
    font-family: 'Courier New', monospace;
}

.quill-content .ql-font-serif {
    font-family: Georgia, serif;
}

.quill-content .ql-font-monospace {
    font-family: 'Courier New', monospace;
}

.quill-content .ql-size-small {
    font-size: 0.75rem;
}

.quill-content .ql-size-large {
    font-size: 1.25rem;
}

.quill-content .ql-size-huge {
    font-size: 1.5rem;
}

/* List styles */
.quill-content .ql-list {
    padding-left: 1.5rem;
}

.quill-content .ql-list.ql-bullet li::before {
    content: '•';
    color: #f97316;
    font-weight: bold;
    display: inline-block;
    width: 1em;
    margin-left: -1em;
}

.quill-content .ql-list.ql-ordered li::before {
    content: counter(list-counter) '. ';
    counter-increment: list-counter;
    color: #f97316;
    font-weight: bold;
}

.quill-content .ql-list.ql-ordered {
    counter-reset: list-counter;
}

/* Video and embed styles */
.quill-content .ql-video {
    width: 100%;
    height: 315px;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

/* Link styles */
.quill-content a[href] {
    color: #f97316;
    text-decoration: underline;
    font-weight: 500;
    transition: color 0.2s ease;
}

.quill-content a[href]:hover {
    color: #ea580c;
}

/* Image styles */
.quill-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;
}

.quill-content img:hover {
    transform: scale(1.02);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .quill-content h1 {
        font-size: 1.875rem;
    }

    .quill-content h2 {
        font-size: 1.5rem;
    }

    .quill-content h3 {
        font-size: 1.25rem;
    }

    .quill-content table {
        font-size: 0.875rem;
    }

    .quill-content th,
    .quill-content td {
        padding: 0.5rem;
    }
}
</style>

