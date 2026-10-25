jQuery(document).ready(function($){
    //----- Open model CREATE -----//
    jQuery('#btn-add').click(function () {
        jQuery('#btn-save').val("add");
        jQuery('#myForm').trigger("reset");
        jQuery('#formModal').modal('show');
    });
    // CREATE
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            nombre: jQuery('#nombre').val(),
            descripcion: jQuery('#descripcion').val(),
        };
        var state = jQuery('#btn-save').val();
        var type = "POST";
        var todo_id = jQuery('#todo_id').val();
        var ajaxurl = 'categoria';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                $("#table_refresh").load(" #table_refresh");
                console.log(state);
                jQuery('#myForm').trigger("reset");
                jQuery('#formModal').modal('hide');
                // Mandamos una alerta
                const Toast = Swal.mixin ({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                      }
                });
                Toast.fire ({
                    icon: 'success',
                    title: data,
                    customClass: 'swal-pop',
                })
            },
            error: function (data) {
                if( data.status === 422 ) {
                    var errors = $.parseJSON(data.responseText);

                    $.each(errors, function (key, value) {
                        // console.log(key+ " " +value);
                        if($.isPlainObject(value)) {
                            document.getElementById('e_nombre').innerHTML = '';
                            document.getElementById('e_descripcion').innerHTML = '';
                            $.each(value, function (key, value) {
                                console.log(key+ " " +value);
                                if (key === 'nombre'){
                                    document.getElementById('e_nombre').innerHTML = value;
                                }
                                if (key === 'descripcion'){
                                    document.getElementById('e_descripcion').innerHTML = value;
                                }
                            });
                        }
                    });
                }
            }
        });
    });
});
