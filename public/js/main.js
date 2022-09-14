let customFormData = {
    classrooms: [],
};
let editKidId = '';
let token = document.querySelector('meta[name="csrf-token"]').content;
let filters = {}

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
            // clearParents(form)
            clearKidsGroups(form);
            clearErrors(form)
        }
        popup.style.display = 'none';
    }

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
// let parentCount = 1;
// function addParentInput(form, value = false) {
//     console.log(value);
//     form.querySelector('div[id=\'parent-inputs\']').querySelector('a').insertAdjacentHTML('beforebegin', '' +
//         '<div data-id-parent="'+ (value ? value.id : '') + '"><div class="added-parent first-column">\n' +
//         '                        <input name="nameParent['+ parentCount +']" value="'+ (value ? value.name : '') + '">\n' +
//         '                    </div><div class="second-column added-parent">\n' +
//         '                        <input type="number" name="numberParent['+ parentCount++ +']" value="'+ (value ? value.number : '') +'">\n' +
//         '                    </div></div>');
// }
function delClassroom(id) {
    for (i = 0; i < customFormData.classrooms.length; ++i) {
        if (customFormData.classrooms[i] == id) {
            customFormData.classrooms.splice(i,1);
            break;
        }
    }

    document.getElementById('addedClassroom-'+id).remove();
}
// function clearParents(form) {
//     customFormData.classrooms = [];
//     let groups = form.getElementsByClassName('added-parent');
//     while(groups[0])
//         groups[0].parentNode.removeChild(groups[0])
// }
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
    let attrs = [].filter.call(form.attributes, function(at) { return /^data-/.test(at.name); });
    let metaData = {};

    for (var i = 0; i < attrs.length; i++)
        metaData = Object.assign(metaData, Object.fromEntries([[attrs[i].name, attrs[i].value]]));
    for (let i = 0; i < inputs.length; i++)
        data = Object.assign(data, Object.fromEntries([[inputs[i].name, inputs[i].value]]));


    data = Object.assign(data, customFormData);
    data.metaData = metaData;

    return data;
}
function nextPage(meta) {
    let filter = {
        page: Number(document.getElementById(meta['data-list']).getAttribute('data-page')) + 1
    }
    refreshList(meta, filter);
}
function showNotificateMessage(notificateBlock, message = null) {
    if(message !== null) {
        notificateBlock.innerHTML = '';
        notificateBlock.insertAdjacentHTML('afterbegin',
            '<p>'+message+'</p>');
    }
    changePopup(notificateBlock, true, 3000)
}
/* AJAXs*/
function refreshList(meta, filter = {}) {

    if(filters[meta['data-list']] == undefined)
        filters[meta['data-list']] = {};

    filter = Object.assign(filters[meta['data-list']], filter)
    filter.metaData = meta;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/"+filter.metaData['data-class']+"s/list",
        dataType: 'json',
        method: "POST",
        data: {
            filter
        },
        contentType: 'application/json',
        success: function (response) {
            let page = 1;
            let table = document.getElementById(filter.metaData['data-list']);
            if (filter['page'] !== undefined)
                page = filter['page'];

            table.setAttribute('data-page', page)

            table.innerHTML = '';
            table.insertAdjacentHTML('afterbegin',
                response.html);
        }
    });
}

function addPopupAjax(button,form) {
    event.preventDefault();
    let data = serializeForm(form);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: button.getAttribute('href'),
        dataType: 'json',
        processData: 'false',
        data: data,
        method: "POST",
        contentType: 'application/json',
        success: function (response) {
            if(response.status){

                refreshList(data.metaData);

                changePopup(form.closest('.popup-back'), false);
                showNotificateMessage(document.getElementsByClassName('notificate-message')[0], response.notificateMessage)
            } else {
                console.log(response);
                clearErrors(form);
                createErrors(response.errors, form);
            }
        },
    });
}
function editPopupAjax(button,form) {
    event.preventDefault();
    let data = serializeForm(form);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: button.getAttribute('href'),
        dataType: 'json',
        processData: 'false',
        data: data,
        method: "PATCH",
        contentType: 'application/json',
        success: function (response) {
            if(response.status){
                refreshList(data.metaData);

                changePopup(form.closest('.popup-back'), false);
                showNotificateMessage(document.getElementsByClassName('notificate-message')[0], response.notificateMessage)

            } else {
                clearErrors(form);
                createErrors(response.errors, form);
            }
        }
    });
}
function delPopupAjax(button,form) {
    event.preventDefault();
    let data = serializeForm(form);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: button.getAttribute('href'),
        dataType: 'json',
        processData: 'false',
        data: data,
        method: "DELETE",
        contentType: 'application/json',
        success: function (response) {
            if(response.status){

                refreshList(data.metaData);

                changePopup(form.closest('.popup-back'), false);
                showNotificateMessage(document.getElementsByClassName('notificate-message')[0], response.notificateMessage)

            }
        },
        errors: function (response) {
            console.log(response);
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
            console.log(response);
            let form = document.getElementById('form-kid-edit');
            form.name.value = response.name;
            form.desc.value = response.desc;
            form.birthday.value = response.birthday;
            form.parents.value = response.parents;
            form.setAttribute('data-id-item', id);

            for(i = 0; i < response.classrooms.length; i++)
                addClassroom(response.classrooms[i].id, document.getElementById('form-kid-edit'));

            // if((Object.keys(response.parents).length > 0))
            //     for(i = 0; i < response.parents.length; i++){
            //         addParentInput(document.getElementById('form-kid-edit'), response.parents[i])
            //     }


            let popupEdit = document.getElementById('editKid');
            popupEdit.getElementsByClassName('button-add')[0].getElementsByTagName('button')[0].setAttribute('href','/kids/'+id);
            popupEdit.getElementsByClassName('button-del')[0].getElementsByTagName('button')[0].setAttribute('href','/kids/'+id);
        }
    });
}
function getPayment(id) {
    editPaymentId = id;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/payments/"+id,
        dataType: 'json',
        method: "GET",
        contentType: 'application/json',
        success: function (response) {
            let form = document.getElementById('form-payment-edit');

            form.name.value = response.name;
            form.desc.value = response.desc;
            form.payment.value = response.payment;
            form['classroom_id'].value = response['classroom_id'];
            form['kid_id'].value = response['kid_id'];
            form['payment_date'].value = response['payment_date'];
            form['payment_option_id'].value = response['payment_option_id'];
            form.setAttribute('data-id-item', id);
            let popupEdit = document.getElementById('editPayment');
            popupEdit.getElementsByClassName('button-add')[0].getElementsByTagName('button')[0].setAttribute('href','/payments/'+id);
            popupEdit.getElementsByClassName('button-del')[0].getElementsByTagName('button')[0].setAttribute('href','/payments/'+id);

        }
    });
}
function getClassroom(id) {
    editClassroomId = id;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : token
        },
        url: "/classrooms/"+id,
        dataType: 'json',
        method: "GET",
        contentType: 'application/json',
        success: function (response) {
            console.log(response);
            let form = document.getElementById('form-classroom-edit');
            form.classroom.value = response.classroom;
            form['price_day'].value = response['price_day'];
            form['price_month'].value = response['price_month'];
            form['price_discount'].value = response['price_discount'];
            form['count_visits'].value = response['count_visits'];
            form.desc.value = response.desc;
            form.setAttribute('data-id-item', id);
            let popupEdit = document.getElementById('editClassroom');
            popupEdit.getElementsByClassName('button-add')[0].getElementsByTagName('button')[0].setAttribute('href','/classrooms/'+id);
            popupEdit.getElementsByClassName('button-del')[0].getElementsByTagName('button')[0].setAttribute('href','/classrooms/'+id);
        }
    });
}



//datapicker
let dataPiker = $('button[name="datefilter"]');

dataPiker.daterangepicker({
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
});

dataPiker.on('apply.daterangepicker', function(ev, picker) {
    refreshList({'data-class':'payment','data-list': $(this).data('list')}, {dateRange: picker.startDate.format('YYYY-MM-DD') + '|' + picker.endDate.format('YYYY-MM-DD')} )
});

dataPiker.on('cancel.daterangepicker', function(ev, picker) {
    refreshList({'data-class':'payment','data-list': $(this).data('list')}, {dateRange: null} )

});





