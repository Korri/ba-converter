$('#upload').fineUploader({
    request: {
        endpoint: PHP_UPLOADER
    },
    validation: {
        sizeLimit: 10 * 1024,
        itemLimit: 100
    },
    //Boostrap style
    text: {
        uploadButton: '<div><i class="icon-upload icon-white"></i> Choose a file to convert</div>',
        dragZone: 'Drop files here to convert'
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
$('#upload').on('complete', function(ev, id, name, json) {
    var link = $('<a/>')
            .text('Download ' + json.name.newname)
            .attr('target', '_blank')
            .attr('href', PHP_DOWNLOAD + json.name.realname + '/' + json.name.newname);
    $('#upload .qq-upload-list li').eq(id).find('.qq-upload-status-text').append(link);

    $('<input type="hidden"/>')
            .attr('name', 'cards[]')
            .attr('value', json.name.realname + ':' + json.name.newname)
            .appendTo('#download_all');
    if (id >= 1) {
        $('#download_all').removeClass('hidden');
    }
});