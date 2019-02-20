<!-- SPECIFIC SCRIPTS -->

jQuery('#sidebar').theiaStickySidebar({
    additionalMarginTop: 80
});

//Script para que el usuario genere nuevos campos
jQuery.fn.generaNuevosCampos = function (nombreCampo1, nombreCampo2) {
    $(this).each(function () {
        elem = $(this);
        elem.data("nombreCampo1", nombreCampo1);
        elem.data("nombreCampo2", nombreCampo2);

        elem.click(function (e) {
            e.preventDefault();
            elem = $(this);
            nombreCampo1 = elem.data("nombreCampo1");
            nombreCampo2 = elem.data("nombreCampo2");
            texto_insertar = '<div class="col-md-4"><div class="form-group"><input type="text" name="' + nombreCampo1 + '" class="form-control" /></div></div><div class="col-md-8"><div class="form-group"><input type="text" name="' + nombreCampo2 + '" class="form-control" /></div></div>';
            nuevo_campo = $(texto_insertar);
            elem.before(nuevo_campo);
        });
    });
    return this;
};

$(document).ready(function () {
    $("#mascamposVariante").generaNuevosCampos("variante1[]", "variante2[]");
});

$(document).ready(function () {
    $("#mascamposAdicional").generaNuevosCampos("adicional1[]", "adicional2[]");
});


$(document).ready(function () {
    $("#masSecciones").click(function () {
        var resultado = $("#val1").val();
        console.log(resultado);
        var option = "<option value='" + resultado + "' selected>" + resultado + "</option>";
        $("#seccionMenu").append(option);
        $("#val1").val("");
    });
});

function eliminarSeccion(id) {
    $('#' + id + ' input:first').attr('type', 'hidden');
    $('#' + id + ' input:first').attr('value', 'eliminado');
    $('#' + id + ' .col-md-10').append('<h5 class="alert alert-danger" style="margin-top: 0;padding: 10px;margin-bottom: 0;">Eliminado</h5>');
    $('#' + id + ' button').hide();
}


//Script para que el usuario genere nuevos campos en """seccion"""
jQuery.fn.generaNuevosCamposSeccion = function (cod, nombreCampo) {
    $(this).each(function () {
        elem = $(this);
        elem.data("cod", cod);
        elem.data("nombreCampo", nombreCampo);

        setInterval(function () {
            var num = 1 + Math.floor(Math.random() * 6);
            return num;
        }, 1000);

        elem.click(function (e) {
            e.preventDefault();
            elem = $(this);
            cod = (elem.data("cod")) + setInterval(1);
            nombreCampo = elem.data("nombreCampo");
            texto_insertar = '<div id="' + cod + '"><div class="col-md-10"><input class="form-control" type="text" name="' + nombreCampo + '" /><input type="hidden" name="cod[]" value="' + cod + '"></div><div class="col-md-2"><button type="button" onclick="eliminar(\'' + cod + '\')" class="btn_1"><i class="icon-cancel-6"></i></button></div><div class="clearfix"></div><br/></div>';
            nuevo_campo = $(texto_insertar);
            elem.before(nuevo_campo);
        });
    });
    return this;
}

$(document).ready(function () {
    $("#mascamposSeccion").generaNuevosCamposSeccion("<?= substr(md5(uniqid(rand())), 0, 10);?>", "titulo[]");
});

//Script para que el usuario genere nuevos campos """VarianteAdicional"""
jQuery.fn.generaNuevosCamposVarianteAdicional = function (nombreCampo1, nombreCampo2) {
    $(this).each(function () {
        elem = $(this);
        elem.data("nombreCampo1", nombreCampo1);
        elem.data("nombreCampo2", nombreCampo2);

        elem.click(function (e) {
            e.preventDefault();
            elem = $(this);
            nombreCampo1 = elem.data("nombreCampo1");
            nombreCampo2 = elem.data("nombreCampo2");
            texto_insertar = '<div class="col-md-4"><div class="form-group"><input type="text" name="' + nombreCampo1 + '" class="form-control" /></div></div><div class="col-md-8"><div class="form-group"><input type="text" name="' + nombreCampo2 + '" class="form-control" /></div></div>';
            nuevo_campo = $(texto_insertar);
            elem.before(nuevo_campo);
        });
    });
    return this;
}

$(document).ready(function () {
    $("#mascamposVariante").generaNuevosCamposVarianteAdicional("variante1[]", "variante2[]");
});

$(document).ready(function () {
    $("#mascamposAdicional").generaNuevosCamposVarianteAdicional("adicional1[]", "adicional2[]");
});


//agregar seccion
document.getElementById('btnSecciones').addEventListener('click', function () {
    document.getElementById('val1').style.display = 'block';
    document.getElementById('masSecciones').style.display = 'block';
}, false);

$(document).ready(function () {
    $("#masSecciones").click(function () {
        var resultado = $("#val1").val();
        var option = "<option value='" + resultado + "' selected>" + resultado + "</option>";
        $("#seccionMenu").append(option);
        $("#val1").val("");
    });
});
