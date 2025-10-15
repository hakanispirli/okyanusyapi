import Quill from 'quill';
import 'quill/dist/quill.snow.css';

export default function quillEditor(config) {
    return {
        quill: null,
        content: config.value || '',
        characterCount: 0,
        isValid: true,
        config: config,

        init() {
            this.$nextTick(() => {
                this.initializeQuill();
            });
        },

        initializeQuill() {
            if (this.quill) {
                this.quill.destroy();
            }

            const toolbarConfig = this.getToolbarConfig();

            this.quill = new Quill(this.$refs.quillContainer, {
                theme: this.config.theme || 'snow',
                placeholder: this.config.placeholder || 'İçeriğinizi yazın...',
                modules: {
                    toolbar: toolbarConfig
                }
            });

            // Set initial content
            if (this.content) {
                this.quill.root.innerHTML = this.content;
            }

            // Update character count
            this.updateCharacterCount();

            // Listen for text changes
            this.quill.on('text-change', () => {
                this.updateContent();
                this.updateCharacterCount();
                this.validateContent();
            });

            // Listen for selection changes
            this.quill.on('selection-change', () => {
                this.updateContent();
            });
        },

        getToolbarConfig() {
            const toolbarOptions = {
                'full': [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ],
                'basic': [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ],
                'minimal': [
                    ['bold', 'italic'],
                    [{ 'list': 'bullet' }],
                    ['clean']
                ]
            };

            return toolbarOptions[this.config.toolbar] || toolbarOptions.basic;
        },

        updateContent() {
            if (this.quill) {
                this.content = this.quill.root.innerHTML;
                this.$refs.hiddenInput.value = this.content;
            }
        },

        updateCharacterCount() {
            if (this.quill) {
                const text = this.quill.getText();
                this.characterCount = text.length;
            }
        },

        validateContent() {
            if (this.config.required) {
                this.isValid = this.content.trim().length > 0;
            } else {
                this.isValid = true;
            }
        },

        getContent() {
            return this.content;
        },

        setContent(content) {
            this.content = content;
            if (this.quill) {
                this.quill.root.innerHTML = content;
                this.updateCharacterCount();
                this.validateContent();
            }
        },

        clear() {
            if (this.quill) {
                this.quill.setText('');
                this.updateContent();
                this.updateCharacterCount();
                this.validateContent();
            }
        }
    };
}
