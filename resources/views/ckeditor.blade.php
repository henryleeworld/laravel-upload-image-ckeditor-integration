<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">
        <style>
            .ck-editor__editable_inline {
               min-height: 500px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-5">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h6 class="text-white">{{ __('CKEditor image upload') }}</h6>
                        </div>
                        <div class="card-body">
                            <div id="editor"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/translations/zh.umd.js" defer></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js" defer></script>
        <script type="module">
            const {Bold, ClassicEditor, Essentials, Font, Image, ImageUpload, Italic, Paragraph} = CKEDITOR;
            class MyUploadAdapter {
                constructor(loader) {
                    // The file loader instance to use during the upload.
                    this.loader = loader;
                }

                // Starts the upload process.
                upload() {
                    return this.loader.file
                        .then( file => new Promise((resolve, reject) => {
                            this._initRequest();
                            this._initListeners(resolve, reject, file);
                            this._sendRequest(file);
                        }));
                }

                // Aborts the upload process.
                abort() {
                    if ( this.xhr ) {
                        this.xhr.abort();
                    }
                }

                // Initializes the XMLHttpRequest object using the URL passed to the constructor.
                _initRequest() {
                    const xhr = this.xhr = new XMLHttpRequest();
                    // Note that your request may look different. It is up to you and your editor
                    // integration to choose the right communication channel. This example uses
                    // a POST request with JSON as a data structure but your configuration
                    // could be different.
                    xhr.open("POST", "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}", true);
                    xhr.responseType = "json";
                }

                // Initializes XMLHttpRequest listeners.
                _initListeners(resolve, reject, file ) {
                    const xhr = this.xhr;
                    const loader = this.loader;
                    const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                    xhr.addEventListener('error', () => reject( genericErrorText ) );
                    xhr.addEventListener('abort', () => reject() );
                    xhr.addEventListener('load', () => {
                        const response = xhr.response;

                        // This example assumes the XHR server's "response" object will come with
                        // an "error" which has its own "message" that can be passed to reject()
                        // in the upload promise.
                        //
                        // Your integration may handle upload errors in a different way so make sure
                        // it is done properly. The reject() function must be called when the upload fails.
                        if (!response || response.error) {
                            return reject( response && response.error ? response.error.message : genericErrorText );
                        }

                        // If the upload is successful, resolve the upload promise with an object containing
                        // at least the "default" URL, pointing to the image on the server.
                        // This URL will be used to display the image in the content. Learn more in the
                        // UploadAdapter#upload documentation.
                        resolve({
                            default: response.url
                        });
                    });

                    // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                    // properties which are used e.g. to display the upload progress bar in the editor
                    // user interface.
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', evt => {
                            if (evt.lengthComputable) {
                                loader.uploadTotal = evt.total;
                                loader.uploaded = evt.loaded;
                            }
                        });
                    }
                }

                // Prepares the data and sends the request.
                _sendRequest( file ) {
                    // Prepare the form data.
                    const data = new FormData();

                    data.append( 'upload', file );

                    // Important note: This is the right place to implement security mechanisms
                    // like authentication and CSRF protection. For instance, you can use
                    // XMLHttpRequest.setRequestHeader() to set the request headers containing
                    // the CSRF token generated earlier by your application.

                    // Send the request.
                    this.xhr.send( data );
                }
            }

            function MyCustomUploadAdapterPlugin(editor) {
                editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
                    // Configure the URL to the upload script in your back-end here!
                    return new MyUploadAdapter(loader);
                };
            }

            ClassicEditor.create(document.querySelector("#editor"), {
                licenseKey: '{{ config('services.ckeditor.key') }}',
                plugins: [
                    Bold,
                    Essentials,
                    Font,
                    Image,
                    ImageUpload,
                    Italic,
                    MyCustomUploadAdapterPlugin,
                    Paragraph,
                ],
                toolbar: [
                    'undo', 'redo',
                    '|',
                    'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                    '|',
                    'bold', 'italic',
                    '|',
                    'uploadImage',
                ],
                language: {
                    ui: 'zh'
                },
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.log(error);
            });
        </script>
    </body>
</html>