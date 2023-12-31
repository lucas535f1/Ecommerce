function deleteTask(id) {
    $.ajax({
        type: "post",
        url: "./php/delete.php",
        data: {
            id: id
        },
        success: function (del) {
            $.ajax({
                type: "post",
                url: "./php/updateList.php",
                success: function (response) {
                    $('.sectionLista').html(response);
                }
            });
        }
    });
}

function addCart(id) {
    $.ajax({
        type: "post",
        url: "./php/addCart.php",
        data: {
            id: id
        },
        success: function (del) {
            $.ajax({
                type: "post",
                url: "./php/publication.php",
                success: function (response) {
                    $('.publicacion').html(response);
                }
            });
        }
    });
}

function deleteCart(id) {
    $.ajax({
        type: "post",
        url: "./php/deleteCart.php",
        data: {
            id: id
        },
        success: function (del) {
            $.ajax({
                type: "post",
                url: "./php/updateCart.php",
                success: function (response) {
                    $('.sectionCart').html(response);
                }
            });
        }
    });
}



function orden(url) {
    alert("funca");
    $.ajax({
        type: "post",
        url: "./php/showAjax.php" + url,
        data: {
            criterio: $("#criterio").val(),
            orden: $("input[name=orden]").val()
        },
        success: function (response) {
            alert("Hello! I am an alert box!!");
            $('.articulosSection').html(response);
        }
    });
}

function prueba(url) {
    $.ajax({
        type: "post",
        url: "./php/showAjax.php" + url,
        data: {
            criterio: $("#criterio").val(),
            orden: $("input[name=orden]:checked").val()
        },
        success: function (response) {
            $('.articulosSection').html(response);
        }
    });
}



function pagina(criterio, orden, urlPaginas, i) {
    $.ajax({
        type: "post",
        url: "./php/showAjax.php?" + urlPaginas + i,
        data: {
            orden: orden,
            criterio: criterio
        },
        success: function (response) {
            $('.articulosSection').html(response);
        }
    });
}