function changePopup(popup, status, time = null){
    if(status){
        popup.style.display = 'block';
        if (time != null)
            setTimeout(function() {
                changePopup(popup,false)
            }, time)
    } else {
        if ((form = popup.querySelector('form')) !== null ) {
            form.reset();
            clearKidsGroups(form);
            clearErrors(form)
        }
        popup.style.display = 'none';
    }

}
let customFormData = {
    classrooms: [],
};
let editKidId = '';
let token = document.querySelector('meta[name="csrf-token"]').content;
let filters = {
    page: 1
}

function addClassroom(id, form) {

    id = Number(id);
    if(id !== 0 && customFormData.classrooms.indexOf(id) < 0) {
        customFormData.classrooms.push(id);

        let select = form.getElementsByTagName('select')[0];
        select.insertAdjacentHTML('afterEnd',
            '<div class="added-classroom" id="addedClassroom-'+id+'">'+
                    '<p>'+select.querySelector('option[value=\''+id+'\']').text+'</p>'+
                    '<i class="fa fa-times" aria-hidden="true" onclick="delClassroom(\''+id+'\')"></i>'+
                    '</div>');
    }
}
function delClassroom(id) {
    for (i = 0; i < customFormData.classrooms.length; ++i) {
        if (customFormData.classrooms[i] == id) {
            customFormData.classrooms.splice(i,1);
            break;
        }
    }

    document.getElementById('addedClassroom-'+id).remove();
}
function clearKidsGroups(form) {
    customFormData.classrooms = [];
    let groups = form.getElementsByClassName('added-classroom');
    while(groups[0])
        groups[0].parentNode.removeChild(groups[0])
}
function clearErrors(form) {
    let errorDivs = form.getElementsByClassName('error-message-input');
    for(i = 0; i < errorDivs.length; i++){
        errorDivs[i].remove();
    }
}
function createErrors(responseErrors, form){
    for (var key in responseErrors)
        if(form.querySelector('[data-error="'+key+'"]') === null)
            form.querySelector('[name="'+key+'"]')
                .insertAdjacentHTML('beforebegin', '<div class="error-message-input" data-error="'+key+'">*Обязательное поле для заполнения</div>')
}
function serializeForm(form) {
    let inputs = form.querySelectorAll('[name]');
    let data = {};

    for (let i = 0; i < inputs.length; i++)
        data = Object.assign(data, Object.fromEntries([[inputs[i].name, inputs[i].value]]));
    data = Object.assign(data, customFormData);

    return data;
}
/* AJAXs*/

function addPopupAjax(form) {
    let data = serializeForm(form);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/ajax/store",
        dataType: 'json',
        processData: 'false',
        data: data,
        method: "POST",
        contentType: 'application/json',
        success: function (response) {
            if(response === 1){

                refreshKidsList();

                changePopup(form.closest('.popup-back'), false);
                changePopup(document.getElementById('notificate-message-add'), true, 3000)
            } else {
                clearErrors(form);
                createErrors(response, form);
            }
        }
    });
}




function addKid(form) {
    let data = {
        name: form.name.value,
        desc: form.desc.value,
        classrooms: classrooms,
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/kids/store",
        dataType: 'json',
        processData: 'false',
        data: data,
        method: "POST",
        contentType: 'application/json',
        success: function (response) {
            if(response === 1){

                refreshKidsList();

                changePopup(form.closest('.popup-back'), false);
                changePopup(document.getElementById('notificate-message-add'), true, 3000)
            } else {
                clearErrors(form);
                createErrors(response, form);
            }
        }
    });
}
function refreshKidsList(filter) {
    filter = Object.assign(filters, filter);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/kids/list",
        dataType: 'json',
        method: "POST",
        data: {
            filter
        },
        contentType: 'application/json',
        success: function (response) {
            let table = document.getElementsByTagName('tbody')[0]
            table.innerHTML = '';
            table.insertAdjacentHTML('afterbegin',
                response.html);
        }
    });
}
function getKid(id) {
    editKidId = id;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/kids/"+id,
        dataType: 'json',
        method: "GET",
        contentType: 'application/json',
        success: function (response) {
            let form = document.getElementById('form-kid-edit');
            form.name.value = response.name;
            form.desc.value = response.desc;
            form.setAttribute('data-id', id);
            for(i = 0; i < response.classrooms.length; i++) {
                addClassroom(response.classrooms[i].id, document.getElementById('form-kid-edit'))
            }
        }
    });
}
function editKid(form) {
    let data = {
        name: form.name.value,
        desc: form.desc.value,
        classrooms: classrooms,
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/kids/update/"+editKidId,
        dataType: 'json',
        processData: 'false',
        data: data,
        method: "PATCH",
        contentType: 'application/json',
        success: function (response) {
            if(response === 1){

                refreshKidsList();

                changePopup(form.closest('.popup-back'), false);
                changePopup(document.getElementById('notificate-message-edit'), true, 3000)

            } else {
                clearErrors(form);
                createErrors(response, form);
            }
        }
    });
}
function delKid(form, id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/kids/"+id,
        dataType: 'json',
        processData: 'false',
        method: "DELETE",
        contentType: 'application/json',
        success: function (response) {
            if(response === 1){

                refreshKidsList();

                changePopup(form.closest('.popup-back'), false);
                changePopup(document.getElementById('notificate-message-delete'), true, 3000)

            }
        },
        errors: function (response) {
            console.log(response);
        }
    });
}




