$('#upload').fineUploader({
    request: {
        endpoint: PHP_UPLOADER
    },
    validation: {
        sizeLimit: 10 * 1024
    },
    //Boostrap style
    text: {
        uploadButton: '<div><i class="icon-upload icon-white"></i> Click here to send a deckfile</div>'
    },
    template: '<div class="qq-uploader span12">' +
            '<pre class="qq-upload-drop-area span12"><span>{dragZoneText}</span></pre>' +
            '<div class="qq-upload-button btn btn-success" style="width: auto;">{uploadButtonText}</div>' +
            '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
            '<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
            '</div>',
    classes: {
        success: 'alert alert-success',
        fail: 'alert alert-error'
    }
});