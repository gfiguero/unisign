jQuery(document).ready(function($) {
    $(".clickableRow").click(function() { window.document.location = $(this).attr("href"); });
    $(".clickableRow").css('cursor', 'pointer');
    $(".switch").bootstrapSwitch({onText: 'Si', offText: 'No'});
    $(".photo").fileinput({'showRemove':false,'showCaption':false,'showUpload':false,'browseLabel':'Seleccionar Foto','removeLabel':'','browseIcon':'<i class="fa fa-camera"></i> ','browseClass':'btn btn-primary btn-block'});
    $(".file").fileinput({'showRemove':false,'showCaption':false,'showUpload':false,'browseLabel':'Seleccionar Archivo','removeLabel':'','browseIcon':'<i class="fa fa-folder-open"></i> ','browseClass':'btn btn-primary'});

});

