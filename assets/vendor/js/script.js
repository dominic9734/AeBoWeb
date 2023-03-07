// loading screen spinner
$(window).on('load', function () {
    setTimeout(function () {
        $('.loader_wrapper').fadeOut();
    }, 100);
});
// end loading screen


var lastpressed, request, seat, scope_all, floor;

function btnSVG(element) {
    let location_info = element.id.split("_");
    request = location_info;
    request_scope = "query";
    $(".remove_content").empty();
    $(".remove_header").addClass("d-none")
    DataAjaxChip(request, request_scope);
    $("#" + element.id).addClass("plan_fill_active")
    if (lastpressed && lastpressed != element.id) {
        $("#" + lastpressed).removeClass("plan_fill_active")
    }
    lastpressed = element.id;
}

function DataAjaxChip(request, request_scope) {
    $.ajax({
        type: "POST",
        url: "../services/controller/seating_data.php",
        data: {
            location: request[0],
            zone: request[1],
            request_scope: request_scope

        },
        success: function (data) {
            let employees = data.employees;
            let rooms = data.rooms;
            for (i = 0; i < employees.length; i++) {
                employee = employees[i];
                var divContainer = $("#wrapper_floor_" + employee.location); // get the container element for the current employee
                var divChip = $('<div>', {
                    class: 'chip m-2 cursor-pointer',
                    id: "employeeID_" + employee.ID,
                    "data-employee": JSON.stringify(employee)
                });
                divChip.click(function () {
                    DisplayEmoloyeeInfo(this)
                });
                var img = $('<img>', { // create a new img element
                    id: 'img-' + (i),
                    src: "../../assets/images/employees_200px/" + employee.employee_image,
                    alt: "MA"
                });
                var spanDisplayName = $('<span>', { // create a new span element for the employee's display name
                    html: employee.nickname
                });
                divChip.append(img, spanDisplayName); // append the img, display name and remove button to the chip element
                divContainer.append(divChip); // append the divider and chip element to the container
                $("#wrapper_label_floor_" + employee.location).removeClass("d-none");
            }

            for (i = 0; i < rooms.length; i++) {

                room = rooms[i];
                var divContainer = $("#wrapper_rooms_floor_" + room.location); // get the container element for the current employee
                var divChip = $('<div>', {
                    class: 'chip m-2 cursor-pointer',
                    id: "roomID" + room.ID,
                    "data-room": JSON.stringify(room)
                });
                divChip.click(function () {
                    DisplayRoomInfo(this)
                });
                var spanDisplayName = $('<span>', { // create a new span element for the employee's display name
                    html: room.room_name
                });
                divChip.append(spanDisplayName); // append the img, display name and remove button to the chip element
                divContainer.append(divChip); // append the divider and chip element to the container
                $("#wrapper_room_label_floor_" + room.location).removeClass("d-none");
            }
        }
    });
}

function DisplayEmoloyeeInfo(chip) {
    $("#employeePFP").remove()
    var employeeData = $(chip).data("employee");
    $("#EmployeeInfo").modal("show"); // show the modal

    var pfpimg = $('<img>', { // create a new img element
        id: 'employeePFP',
        class: 'rounded-circle shadow-sm profile_img',
        src: "../../assets/images/employees_200px/" + employeeData.employee_image,
        alt: " "
    });

    $("#wrapper_pfp").append(pfpimg);

    $("#full_name").html(employeeData.first_name + " " + employeeData.last_name);
    $("#location").html(employeeData.location);
    $("#zone").html(employeeData.zone);
    $("#work_division").html(employeeData.work_division);
    $("#internal_phone").html("Intern: +41 61 365 2 " + employeeData.internal_phone);
    if (employeeData.mobile_phone) {
        $("#mobile_phone").html("Privat: " + employeeData.mobile_phone);
    }
    $("#primary_mail").html(employeeData.primary_mail);
    $("#special_authority").html(employeeData.special_authority);
    $("#department").html(employeeData.department);

    $("#mailto_outlook").attr("href", "mailto:" + employeeData.primary_mail);
    $("#link_teams").attr("href", "https://teams.microsoft.com/l/chat/0/0?users=" + employeeData.primary_mail);

}

function DisplayRoomInfo(chip) {
    var roomData = $(chip).data("room");
    $("#RoomInfo").modal("show"); // show the modal

    $("#wrapper_png").empty();
    $("#room_name").html(roomData.room_name);

    var room_name = roomData.room_name.replace(/\s/g, "_");


    var roomPNG = $('<img>', { // create a new img element
        id: 'roomPNG',
        class: 'img-fluid rounded mb-3 d-block',
        src: "../../assets/images/img/" + room_name + ".jpg",
        alt: ""
    });
    $("#wrapper_png").append(roomPNG);

    $.ajax({
        type: "POST",
        url: "../services/controller/seating_data.php",
        data: {

            location: roomData.location,
            zone: roomData.zone,
            work_division: roomData.work_division,
            request_scope: "departmentquery"

        },
        success: function (data) {
            $("#wrapper_room_content").empty();
            let members = data.members;
            var membersHeader = $('<h4 class="text-center m-2">Verantwortliche</h4>', { // create a new img element
            });
            if (members.length < 0) {
                $("#wrapper_room_content").append(membersHeader);
            }
            if (members) {
                for (i = 0; i < members.length; i++) {
                    member = data.members[i];
                    var row = $('<div>', { // create a new img element
                        class: 'row my-2',
                    });
                    var row2 = $('<div> ', { // create a new img element
                        class: 'col-2 pe-0'
                    });
                    var row8 = $('<div> ', { // create a new img element
                        class: 'col-6 ps-0 d-flex align-items-center'
                    });
                    var span = $('<span>', { // create a new img element
                    });
                    span.html(member.first_name + " " + member.last_name)
                    var row4 = $('<div>', { // create a new img element
                        class: 'col-4 d-flex justify-content-end',
                    });
                    var pfpimg = $('<img>', { // create a new img element
                        id: 'employeePFP',
                        class: 'rounded-circle shadow-sm',
                        src: "../../assets/images/employees_200px/" + member.employee_image,
                        style: "height:75px;",
                        alt: " "
                    });
                    var outlooklink = $('<a>', { // create a new img element
                        class: 'pe-2',
                        href: "mailto:" + member.primary_mail
                    });
                    var teamslink = $('<a>', { // create a new img element
                        class: 'pe-2',
                        href: "https://teams.microsoft.com/l/chat/0/0?users=" + member.primary_mail
                    });

                    var outlookincon = $('<img>', { // create a new img element
                        src: '../../assets/SVG/icons8-microsoft-outlook-2019.svg',
                        style: "height:50px;"
                    });
                    var teamsicon = $('<img>', { // create a new img element
                        src: '../../assets/SVG/icons8-microsoft-teams.svg',
                        style: "height:50px;"
                    });
                    row2.append(pfpimg);
                    row8.append(span);
                    row4.append(outlooklink, teamslink);
                    outlooklink.append(outlookincon);
                    teamslink.append(teamsicon);
                    row.append(row2, row8, row4);
                    $("#wrapper_room_content").append(row);
                }
            }
        }
    });

}
$(document).ready(function () {


    $(window).scroll(function () {
        if ($(this).scrollTop() >= 100) {
            $('.back_to_top').show();
        } else {
            $('.back_to_top').hide();
        }
    });


    //Click event to scroll to top
    $('.scrollTop',).click(function () {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 200);
        return false;
    });
});

$(document).ready(function () {

    var NamesSearchListItems = $('#employeesearchbox').children().find('*').toArray();

    $('#txtSearch').on('input', function () {
        $('#employeesearchbox').show()
        const searchTerm = $(this).val().toLowerCase();
        const matchingNames = NamesSearchListItems.filter(name => name.innerHTML.toLowerCase().includes(searchTerm));

        const suggestionsList = $('#employeesearchbox');
        suggestionsList.empty();
        matchingNames.slice(0, 5).forEach(name => suggestionsList.append($('<li>').append(name)));
    });

});

function setSearchEmployeeAjax(element) {
    SearchEmployeeAjaxData = $(element).data("listdata")
    SearchEmployeeAjax(SearchEmployeeAjaxData);
}
$(document).ready(function () {
    $("input").keypress(function (event) {
        if (event.which == 13) {
            SearchEmployeeAjaxData = $("#txtSearch").val();
            SearchEmployeeAjax(SearchEmployeeAjaxData);
        }
    });
});
function SearchEmployeeAjax(SearchEmployeeAjaxData) {
    $('#employeesearchbox').hide()
    $(".remove_content").empty();
    $(".remove_header").addClass("d-none")
    $.ajax({
        type: "POST",
        url: "../services/controller/seating_data.php",
        data: {
            request: SearchEmployeeAjaxData,
            request_scope: "location_zone"
        },
        success: function (data) {
            seat = data.location + "_" + data.zone
            floor = data.location;
            sectorsearch(seat, floor);
        }
    });
    $("#txtSearch").val('')
}





function sectorsearch(seat, floor) {
    $("#" + seat).addClass("plan_fill_active")
    if (lastpressed && lastpressed != seat) {
        $("#" + lastpressed).removeClass("plan_fill_active")
    }
    lastpressed = seat;
    request = seat.split("_");
    request_scope = "query";

    $([document.documentElement, document.body]).animate({
        scrollTop: $("#" + "floor_" + floor).offset().top
    }, 1500);
    
    DataAjaxChip(request, request_scope);
}
$(document).keydown(function (event) {
    if (event.key === "Escape" || event.key === "Esc") {
        $(".plan_fill_none").removeClass("plan_fill_active")
        $(".remove_content").empty();
        $(".remove_header").addClass("d-none")


    }
});

//---------------------------------------------------------------------------------------------------------
//js user books
//---------------------------------------------------------------------------------------------------------


function InfoOffcanvas(entry) {
    const bookdata = $(entry).data("bookdata").split('#');
    $("#book_title").html(bookdata[1]);
    $("#book_autor").html(bookdata[2]);
    $("#book_edition").html(bookdata[3]);
    $("#book_number").html(bookdata[6]);
    var bookingbtn = $("#bookingbtn");
    var pdfbtn = $("#pdfbtn");

    if (bookdata[9] == 0) {
        bookingbtn.show();
    } else {
        bookingbtn.hide();
    }

    if (bookdata[8] == 0) {
        pdfbtn.hide();
    } else {
        pdfbtn.show();
    }
    bookingbtn.attr("href", "booking.php?bookID=" + bookdata[0].trim());
    pdfbtn.attr("href", "../pdf_view/web/viewer.php?pdfID=" + bookdata[6].trim() + ".pdf");
}


//---------------------------------------------------------------------------------------------------------
//end js user magazines
//---------------------------------------------------------------------------------------------------------

// BS Tooltip trigger
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

//---------------------------------------------------------------------------------------------------------
//js user magazines
//---------------------------------------------------------------------------------------------------------


var RemovedEmployees = []; // array for all the from the delivery list removed employees
var AddedEmployees = []; // array for all the from the delivery list added employees
let IDs, names, path, magazineID, employeeID;



function MagazineModal(entry) {
    ResetInputs();

    var magazineArray = $(entry).data("magazine");
    magazineID = magazineArray[4]; // get id from entry element's data attribute



    document.getElementById("magCover").setAttribute('src', magazineArray[5]);


    $.ajax({
        type: "POST",
        url: "../services/controller/mag_data.php",
        data: {
            magazineID: magazineID
        },
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                var employeeID = data[i].employeeID;
                var nickname = data[i].nickname;
                var path = data[i].path;
                var full_name = data[i].first_name + " " + data[i].last_name

                AddChips(employeeID, nickname, path, full_name)
            }
        }
    });


    $("#MagazineAutor").html(magazineArray[1]); // set the magazine title in the modal
    $("#MagazineTitle").html(magazineArray[0]); // set the magazine title in the modal
    $("#MagazineCurrent").html(magazineArray[3]); // set the magazine title in the modal
    $("#MagazineTotal").html(magazineArray[2]); // set the magazine title in the modal
    $("#MagazineLanguage").html(magazineArray[6]); // set the magazine title in the modal
    $("#MagazineModal").modal("show"); // show the modal
}

function ResetInputs() {
    RemovedEmployees = []
    AddedEmployees = []
    $("#RemovedSubsList").empty();
    $(".remove").remove();
}

function ConfirmSubs() {
    $.ajax({
        type: "POST",
        url: "../services/controller/mag_addsubs.php",
        data: {
            RemovedEmployees: RemovedEmployees,
            AddedEmployees: AddedEmployees,
            magazineID: magazineID
        },
        async: false,
        success: function (data) {
            ResetInputs()
        }
    });
}

function AddChips(employeeID, nickname, path, full_name) {
    var divContainer = $("#subs_wrapper"); // get the container element for the current employee
    divContainer.removeClass("d-none").addClass(" p-2"); // show the container and set its class to  p-2
    $("#employee-input-container, #filler_div").addClass("d-none"); // hide input container and filler div

    var divChip = $('<div>', { // create a new chip element
        class: 'chip m-2 remove',
        id: "employeeID_" + employeeID
    });
    var img = $('<img>', { // create a new img element
        src: path,
        alt: " "
    });
    var spanDisplayName = $('<span>', { // create a new span element for the employee's display name
        html: nickname
    });
    var spanRemove = $('<span>', { // create a new span element for the remove button
        class: 'RemoveSub',
        html: '&times;',
        "data-value": employeeID,
        "data-name": full_name,
        onclick: "RemoveEmployee(this)"
    });
    var spanDivider = $('<div>', { // create a new span element for the divider
        class: 'mx-1 text-cente remove',
        id: "devider_" + employeeID,
        html: ' &#62;'
    });

    var modify_chip = $("#modify_chip").detach()

    divChip.append(img, spanDisplayName, spanRemove); // append the img, display name and remove button to the chip element
    divContainer.append(divChip, spanDivider,); // append the divider and chip element to the container
    divContainer.append(modify_chip);

    ModifyChip();
}


//function to remove subscription chips from the dom and add their value to a hidden input
function RemoveEmployee(element) {
    RemovedEmployees.push(element.dataset.value) // push the employeeid value to the RemovedEmployees array
    $("#employeeID_" + (element.dataset.value)).addClass("d-none")
    $("#devider_" + (element.dataset.value)).addClass("d-none")

    var RemovedSubsListItem = $('<li>', { // create a new list element
        class: 'list-group-item',
        html: "&#45; " + element.dataset.name
    });
    $("#RemovedSubsList").append(RemovedSubsListItem);
    ModifyChip();
}

function ModifyChip() {
    if ($(".chip").not(".d-none").length > 24) {
        $("#modify_chip").hide();
    } else {
        $("#modify_chip").show();
    }
}

function AddSubBtn() {
    var chip_input_field_value = $("#chip_input_field").val();
    $.ajax({
        type: "POST",
        url: "../services/controller/input_validation.php",
        data: {
            magazineID: magazineID,
            employeeID: chip_input_field_value,
        },
        success: function (data) {

            var employeeID = data.employeeID;
            var nickname = data.nickname;
            var path = data.path;

            if (data.response == "valid") {
                $("#chip_input_field").val('');
                var AddedSubsListItem = $('<li>', { // create a new list element
                    class: 'list-group-item',
                    html: "&#43; " + data.full_name
                });
                $("#RemovedSubsList").append(AddedSubsListItem);
                $("#option_" + nickname).addClass("d-none");

                AddedEmployees.push(employeeID)

                AddChips(employeeID, nickname, path)
            } else {
                alert("Befindet sich bereits in der Zyrkulation")
            }
        }
    });
}

$('#MagazineModalConfirm').on('hidden.bs.modal', function () {
    ResetInputs()
});

//---------------------------------------------------------------------------------------------------------
//end js magazines
//---------------------------------------------------------------------------------------------------------
