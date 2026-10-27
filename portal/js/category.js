function closeWindow() {
    let arrayClosed = ['viewMenu', 'editName', 'itemImageShow', 'menuBox', 'newCategory', 'newItem', 'delName'];

    for (obj in arrayClosed) {
        $("#" + arrayClosed[obj] + "").css({
            'display': 'none'
        })
    }
}

function closeWindow2() {
    $("#userSubCategory").css({
        "display": "none"
    })
}

function closeWindow3() {
    $("#newAddOs").css({
        "display": "none"
    })
    $("#userSubCategory").css({
        "display": "inline-flex"
    })
}

function send(valor) {

    var form = $("#" + valor)[0];
    var data = new FormData(form);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: valor + ".php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            // Result available to the UI; do not log partner data.

            if (valor == "insertCategory") {
                loadCategory();
                closeWindow();
            } else if (valor == "categoryChageName") {
                loadCategory();
                closeWindow();
            } else if (valor == "categoryChageDel") {
                loadCategory();
                closeWindow();
            } else if (valor == "insertSubCategory") {
                loadCategory();
                $("#newSubCategory").css({
                    "display": "none"
                })
                $(".newSubCategoryBox1").css({
                    "display": "none"
                })
                $(".newSubCategoryBox2").css({
                    "display": "none"
                })
                showUserSubCategory(data);
            } else if (valor == "categoryChageDel") {
                loadCategory();
                showUserSubCategory(data);
            } else if (valor == "newItemCategory") {
                $("#newAddOs").css({
                    "display": "none"
                });
                addOsSubUserItem();
            } else {
                return;
            }
        }
    });
}


function send2(valor) {

    var form = $("#" + valor)[0];
    var data = new FormData(form);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: valor + ".php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            // Result available to the UI; do not log partner data.

            if (valor == "categoryChageDelItem") {
                $("#delItem").css({
                    "display": "none"
                })
                addOsSubUserItem();
            } else if (valor == "categorySubDelItem") {
                $("#delSubCategory").css({
                    "display": "none"
                })
                addOsSubUserItem();
            } else {
                return;
            }
        }
    });
}


function nextNewItem(valor, e) {
    let arrayItens = ["newItemDetails", "newItemAddOs", "newItemRating", "newItemAvailability"];
    for (obj in arrayItens) {
        $("." + arrayItens[obj] + "").removeClass('subMenuactive');
        $("." + arrayItens[obj].replace("newItem", "").toLowerCase() + "").css({
            'display': 'none'
        })
        console.log(arrayItens[obj].replace("newItem", "").toLowerCase());
    }

    $(".newItem" + valor.charAt(0).toUpperCase() + valor.slice(1) + "").addClass('subMenuactive');
    $("." + valor.toLowerCase()).css({
        'display': 'inline-flex'
    })

    console.log(valor);

    return false;
}

function addCategory() {
    $("#viewMenu").css({
        'display': 'inline-block'
    })

    $("#menuBox").css({
        'display': 'inline-block'
    })
}

function addCategoryItens() {
    $("#menuBox").css({
        'display': 'none'
    })

    $("#newCategory").css({
        'display': 'inline-flex'
    })
}

function loadCategory() {
    $.ajax({
        url: './viewCategory.php',
        method: 'POST',
        success: function (resp) {
            $('#viewCategory').html(resp);
        }
    });
}
loadCategory();

function categoryItem(valor1, valor2) {
    $("#newItem").css({
        'display': 'flex'
    })

    $(".details").css({
        'display': 'flex'
    })

    $("#viewMenu").css({
        'display': 'inline-block'
    })

    $("#editNameCategory").val(valor2);
    $("#editNameCategoryID").val(valor1);
}

function categoryName(valor1, valor2) {
    $("#editNameCategory2").attr('class', 'newCategoryButtonEnabled');

    $("#editName").css({
        'display': 'inline-flex'
    })

    $("#viewMenu").css({
        'display': 'inline-block'
    })

    $("#editNameCategory").val(valor2);
    $("#editNameCategoryID").val(valor1);
    $("#sendCategory2").attr('class', 'newCategoryButtonEnabled');
}

function categoryDel(valor1, valor2) {
    $("#delName").css({
        'display': 'inline-flex'
    })

    $("#viewMenu").css({
        'display': 'inline-block'
    })

    $("#categoryNameDel").text(valor2);
    $("#delNameCategoryID").val(valor1);
}

function categorySubDel(valor1, valor2) {
    $("#delSubCategory").css({
        'display': 'inline-flex'
    })

    $("#userSubCategory").css({
        'display': 'none'
    })

    $("#viewMenu").css({
        'display': 'inline-block'
    })

    $("#categoryNameDel3").text(valor2);
    $("#delNameCategoryID3").val(valor1);
}

function categoryDelItem(valor1, valor2) {
    $("#delItem").css({
        'display': 'inline-flex'
    })

    $("#viewMenu").css({
        'display': 'inline-block'
    })

    $("#userSubCategory").css({
        "display": "none"
    })

    $("#categoryNameDel2").text(valor2);
    $("#delNameCategoryID2").val(valor1);
}

var subCategoriOptionalMin = 0;
var subCategoriOptionalMax = 1;
var subCategoriRequiredMin = 1;
var subCategoriRequiredMax = 1;
var subCategoriOptional = false;
var subCategoriRequired = false;
var sebCategoryActive = false;
var sebCategoryName = false;
var sebCategoryForm = false;

function subCategoryRangeMin1() {
    if (subCategoriOptional == true) { } else if (subCategoriRequired == true) {
        if (parseFloat($("#subCategoryRangeView1").html()) > 1) {
            $("#subCategoryRangeView1").html(parseFloat($("#subCategoryRangeView1").html()) - 1);
        }
    }
}

function subCategoryRangeMax1() {
    if (subCategoriOptional == true) { } else if (subCategoriRequired == true) {
        if (parseFloat($("#subCategoryRangeView1").html()) < 25) {
            $("#subCategoryRangeView1").html(parseFloat($("#subCategoryRangeView1").html()) + 1);
        }
    }
}

function subCategoryRangeMax2() {
    if (subCategoriOptional == true) {
        if (parseFloat($("#subCategoryRangeView2").html()) < 25) {
            $("#subCategoryRangeView2").html(parseFloat($("#subCategoryRangeView2").html()) + 1);
        }
    } else if (subCategoriRequired == true) {
        if (parseFloat($("#subCategoryRangeView2").html()) < 25) {
            $("#subCategoryRangeView2").html(parseFloat($("#subCategoryRangeView2").html()) + 1);
        }
    }
}

function subCategoryRangeMin2() {
    if (subCategoriOptional == true) {
        if (parseFloat($("#subCategoryRangeView2").html()) > 1) {
            $("#subCategoryRangeView2").html(parseFloat($("#subCategoryRangeView2").html()) - 1);
        }
    } else if (subCategoriRequired == true) {
        if (parseFloat($("#subCategoryRangeView2").html()) > 1) {
            $("#subCategoryRangeView2").html(parseFloat($("#subCategoryRangeView2").html()) - 1);
        }
    }
}

$('#addOsYes').on('input', function (e) {
    $(".addOsBox").css({
        "display": "flex"
    })

    $("#sendNewItem2").attr('class', 'newCategoryButtonEnabled');
});

$("#addOsSubCategory").on("click", function () {
    $("#newSubCategory").css({
        "display": "inline-flex"
    })
    $(".newSubCategoryBox1").css({
        "display": "inline-flex"
    })
})

$("#addOsSubUser").on("click", function () {
    addOsSubUserItem();
})

function addOsSubUserItem() {
    $("#userSubCategory").css({
        "display": "inline-flex"
    })

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "view_add_OS.php",
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            $("#userSubCategory").html(data)
        }
    });
}


$("#nameCategory").on('keyup', function () {
    if ($("#nameCategory").val().length >= 3) {
        $("#sendCategory").attr('class', 'newCategoryButtonEnabled');
    } else {
        $("#sendCategory").attr('class', 'newCategoryButtonDisabled');
    }
})

$("#newItemName").on('keyup', function () {
    console.log('button1')
    if ($("#newItemName").val().length >= 3) {
        if ($("#newItemSale").val().length >= 3) {
            $("#sendCategory2").attr('class', 'newCategoryButtonEnabled');
        }
    } else {
        $("#sendCategory2").attr('class', 'newCategoryButtonDisabled');
    }
})

$("#newItemSale").on('keyup', function () {
    console.log('button2')
    if ($("#newItemSale").val().length >= 3) {
        if ($("#newItemName").val().length >= 3) {
            $("#sendCategory2").attr('class', 'newCategoryButtonEnabled');
        }
    } else {
        $("#sendCategory2").attr('class', 'newCategoryButtonDisabled');
    }
})

$("#editNameCategory").on('keyup', function () {
    console.log('button2')
    if ($("#editNameCategory").val().length >= 3) {
        $("#editNameCategory2").attr('class', 'newCategoryButtonEnabled');
    } else {
        $("#editNameCategory2").attr('class', 'newCategoryButtonDisabled');
    }
})

$("#SubCategoryItemName2").on('keyup', function () {
    if ($("#SubCategoryItemName2").val().length >= 3) {
        if ($("#newItemCategorySale2").val().length >= 3) {
            $("#sendSubCategory3").attr('class', 'newCategoryButtonEnabled');
        } else {
            $("#sendSubCategory3").attr('class', 'newCategoryButtonDisabled');
        }
    } else {
        $("#sendSubCategory3").attr('class', 'newCategoryButtonDisabled');
    }
})

$("#newItemCategorySale2").on('keyup', function () {
    if ($("#newItemCategorySale2").val().length >= 3) {
        if ($("#SubCategoryItemName2").val().length >= 3) {
            $("#sendSubCategory3").attr('class', 'newCategoryButtonEnabled');
        } else {
            $("#sendSubCategory3").attr('class', 'newCategoryButtonDisabled');
        }
    } else {
        $("#sendSubCategory3").attr('class', 'newCategoryButtonDisabled');
    }
})



$("#newSubCategoryOptional").on('input', function (e) {
    $("#newSubCategoryRangeMin span:nth-child(2)").html(0);
    $("#newSubCategoryRangeMax span:nth-child(2)").html(1);

    $("#newSubCategoryRangeMin").css({
        "background": "#e3e3e3",
        "color": "#757575"
    })

    $("#newSubCategoryRangeMax").css({
        "background": "rgb(255 255 255)",
        "color": "rgb(0 0 0)"
    })

    subCategoriOptional = true;
    subCategoriRequired = false;
    sebCategoryActive = true;
    sebCategoryAnalize();
});

$("#newSubCategoryRequired").on('input', function (e) {
    $("#newSubCategoryRangeMin span:nth-child(2)").html(1);
    $("#newSubCategoryRangeMax span:nth-child(2)").html(1);

    $("#newSubCategoryRangeMin").css({
        "background": "rgb(255 255 255)",
        "color": "rgb(0 0 0)"
    })

    $("#newSubCategoryRangeMax").css({
        "background": "rgb(255 255 255)",
        "color": "rgb(0 0 0)"
    })

    subCategoriOptional = false;
    subCategoriRequired = true;
    sebCategoryActive = true;
    sebCategoryAnalize();
});

$("#editNameSubCategory").on('keyup', function () {
    if ($("#editNameSubCategory").val().length >= 3) {
        sebCategoryName = true;
        sebCategoryAnalize();
    } else {
        sebCategoryName = false;
        sebCategoryAnalize();
    }
})

function sebCategoryAnalize() {
    if (sebCategoryActive == true) {
        if (sebCategoryName == true) {
            $("#sendSubCategory").attr('class', 'newCategoryButtonEnabled');
            sebCategoryForm = true;
        } else {
            sebCategoryForm = false;
            $("#sendSubCategory").attr('class', 'newCategoryButtonDisabled');
        }
    } else {
        sebCategoryForm = false;
        $("#sendSubCategory").attr('class', 'newCategoryButtonDisabled');
    }
}

function sendSubCategory() {
    $(".newSubCategoryBox1").css({
        "display": "none"
    })
    $(".newSubCategoryBox2").css({
        "display": "inline-flex"
    })

    $("#subCategoryRange1").val($("#subCategoryRangeView1").html());
    $("#subCategoryRange2").val($("#subCategoryRangeView2").html());
}


$("#addOsSubUser").on("click", function () {
    showUserSubCategory();
})

function showUserSubCategory(valor) {
    $("#userSubCategory").css({
        "display": "inline-flex"
    })

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "view_add_OS.php",
        processData: false,
        contentType: false,
        data: 'id=' + valor,
        cache: false,
        timeout: 600000,
        success: function (data) {
            $("#userSubCategory").html(data)
        }
    });
}

function addNewItemCategory(valor) {
    $("#newAddOs").css({
        "display": "inline-flex"
    })

    $("#userSubCategory").css({
        "display": "none"
    })

    $("#newItemCategoryId").val(valor);
}

$("#availabilityRadioYes").on('input', function () {
    $(".boxTurn").css({
        "display": "none"
    })
    $(".turnButton").css({
        "display": "none"
    })
})

$("#availabilityRadioNo").on('input', function () {
    $(".turnButton").css({
        "display": "inline-flex"
    })
})

function sendItem() {

    var form = $("#insertNewItem")[0];
    var data = new FormData(form);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "insertItem.php",
        processData: false,
        contentType: false,
        data: data,
        cache: false,
        timeout: 600000,
        success: function (data) {
            // Result available to the UI; do not log partner data.
            loadCategory();
            closeWindow();
        }
    });
}
var turnNumber = 0;
var arrayTurn = [];
var date = [];
var dataArray = ['sundayTurn', 'mondayTurn', 'thirdTurn', 'fourthTurn', 'thursdayTurn', 'fridayTurn', 'saturdayTurn'];
var setData = "";

$(".turnButton").on('click', function () {
    $(".boxTurn").css({
        "display": "inline-flex"
    })

    for (obj in dataArray) {
        $("." + dataArray[obj]).removeClass('turnActive');
    }

    turnNumber++;

    $("#turnNumber").html(turnNumber+"° Turno");
})


function turnDaySend(valor) {
    console.log(valor)
    if ($("." + valor).attr('class').split(' ')[1] == 'turnActive') {
        $("." + valor).removeClass('turnActive');
    } else {
        $("." + valor).addClass('turnActive');
    }
}

function sendTurn() {
    for (obj in dataArray) {
        if ($("." + dataArray[obj]).attr('class').split(' ')[1] == 'turnActive') {
            date.push(date[obj]);
        }
    }

    arrayTurn.push(
        {
            turn: turnNumber,
            hour1: "" + $("#turn1In").val() + "",
            hour2: "" + $("#turn1Out").val() + "",
            date: date
        }
    );

    console.log(arrayTurn);

    $(".boxTurn").css({
        "display": "none"
    })

    setData = "";

    for (obj in dataArray) {
        if ($("." + dataArray[obj]).attr('class').split(' ')[1] == 'turnActive') {
            if (obj == 0) {
                setData = setData + '<span title="Domingo" class="turnActive">D</span>';
            } else if (obj == 1) {
                setData = setData + '<span title="Segunda" class="turnActive">S</span>';
            } else if (obj == 2) {
                setData = setData + '<span title="Terça" class="turnActive">T</span>';
            } else if (obj == 3) {
                setData = setData + '<span title="Quarta" class="turnActive">Q</span>';
            } else if (obj == 4) {
                setData = setData + '<span title="Quinta" class="turnActive">Q</span>';
            } else if (obj == 5) {
                setData = setData + '<span title="Sexta" class="turnActive">S</span>';
            } else if (obj == 6 ) {
                setData = setData + '<span title="Sabado" class="turnActive">S</span>';
            }
        } else {
            if (obj == 0) {
                setData = setData + '<span title="Domingo" >D</span>';
            } else if (obj == 1) {
                setData = setData + '<span title="Segunda">S</span>';
            } else if (obj == 2) {
                setData = setData + '<span title="Terça">T</span>';
            } else if (obj == 3) {
                setData = setData + '<span title="Quarta">Q</span>';
            } else if (obj == 4) {
                setData = setData + '<span title="Quinta">Q</span>';
            } else if (obj == 5) {
                setData = setData + '<span title="Sexta">S</span>';
            } else if (obj == 6 ) {
                setData = setData + '<span title="Sabado">S</span>';
            }
        }
    }

    $(".viewTurn").append(`
        <div class="turnViewInput2">
            <div class="turnViewButton2">
                `+ turnNumber + `° Turno
                </span>
            </div>
            <div class="turnViewHover2">
                <div class="turnDay">
                    <div>
                        Dias da semana
                    </div>
                    <div>`
                    + setData +
                    `</div>
                </div>
                <div class="turnViewButton">
                    <div onmouseup="turnEdit(`+turnNumber+`)">Editar</div>  
                    <div onmouseup="turnRemove(`+turnNumber+`)">Excluir<span class="xmark" onmouseup="closeWindow()"></div>
                </div>
            </div>
        </div>`);
}

function turnEdit(valor) {
    $(".boxTurn").css({
        "display": "inline-flex"
    })

    for (obj in dataArray) {
        $("." + dataArray[obj]).removeClass('turnActive');
    }

    turnNumber++;

    $("#turnNumber").html(turnNumber+"° Turno");
}