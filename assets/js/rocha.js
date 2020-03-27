function editProduct(id, url) {
    event.preventDefault();
    var data = id.split("-");

    console.log(url);

    $.ajax({
        url: url + '/api/products/edit.php',
        type: "POST",
        data: {
            attr: data[0],
            value: "'" + $("#" + id).val() + "'",
            cod: data[1]
        },
        success: function (data) {
            console.log(data);
            if (data) {
                successMessage("Producto actualizado correctamente");
            } else {
                errorMessage("El producto no se ha actualizado");
            }
        }
    });
}

function errorMessage(message) {
    $.notify({
        icon: 'fa fa-times-circle',
        message: message,
    }, {
        element: 'body',
        type: "danger",
        placement: {
            from: "bottom",
            align: "right"
        },
        delay: 5000,
        timer: 1000,
        mouse_over: null,
        icon_type: 'class',
        template:
            '<div class="col-xs-10 col-md-6 pull-right">' +
            '<div data-notify="container" class=" alert alert-{0}" role="alert">' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="message" style="color:black">{2}</span>' +
            '</div>' +
            '</div>'
    });
}

function successMessage(message) {
    $.notify({
        // options
        icon: 'fa fa-check-circle',
        message: message,
    }, {
        // settings
        element: 'body',
        type: "success",
        placement: {
            from: "bottom",
            align: "right"
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        icon_type: 'class',
        template:
            '<div class="col-xs-10 col-md-6 pull-right">' +
            '<div data-notify="container" class=" alert alert-{0}" role="alert">' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="message" style="color:black">{2}</span>' +
            '</div>' +
            '</div>'
    });
}

function openVariantions(url, cod) {
    btnVariations(true);
    $.ajax({
        url: url + '/api/variations/read.php',
        type: "POST",
        data: {
            cod: cod,
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data['status']) {
                $('#variationsModalForm').html('');
                $('#variationsModalTitle').html('');
                $('#variationsModalTitle').append(data['title']);
                $('#variationsModalForm').append(data['variations']);
                $('#variationsModal').modal('show');
            } else {
                errorMessage(data['message']);
                btnVariations(false);
            }
        }
    });
}

function updateVariations(url) {
    $.ajax({
        url: url + '/api/variations/update.php',
        type: "POST",
        data: $('#variationsModalForm').serialize(),
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data['status']) {
                $('#variationsModal').modal('hide');
                successMessage(data['message']);
            } else {
                errorMessage(data['message']);
            }
            btnVariations(false);
        }
    });
}

function btnVariations(status) {
    $('.variations-button').attr('disabled', status);
    if (!status) {
        $('.variations-button').css({'background-color': ''});
    } else {
        $('.variations-button').css({'background-color': ' #727271'});
    }
}

$('#variationsModal').on('hidden.bs.modal', function () {
    btnVariations(false);
});