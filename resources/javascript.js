// Email checkmarks
function email(id, coupleID, obj) {
    $(obj).removeClass("btn-danger").addClass("btn-success");
    $(obj).find('i').removeClass("fa-times").addClass("fa-check");
    $(obj).find('i').load('couple_tab/update_email.php?id=' + id + '&coupleID=' + coupleID);
}

// Reservation checks
function retreatReserve(id, retreat, obj) {
    $(obj).removeClass("btn-danger").addClass("btn-success");
    $(obj).load('retreat_tab/reserve_retreat.php?id=' + id + '&retreatID=' + retreat);
}

// Call Status Submit
function callStatus(id, obj) {
    $(obj).removeClass("btn-danger").addClass("btn-success");
    $(obj).find('i').load('couple_tab/update_call.php?coupleID=' + id);
}

// Window Overlay
function toggleOverlay() {
	var overlay = document.getElementById('overlay');
	var specialBox = document.getElementById('specialBox');
	overlay.style.opacity = 0.5;
	if (overlay.style.display === "block") {
		overlay.style.display = "none";
		specialBox.style.display = "none";
	} else {
		overlay.style.display = "block";
		specialBox.style.display = "inline-block";
	}
}

// Add Retreat form
function addRetreat() {
    $("#specialBox").find('#specialBoxWrapper').load('retreat_tab/add_retreat_form.php', function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
    toggleOverlay();
}

//Delete retreats
function deleteRetreat() {
    $("#specialBoxWrapper").load('retreat_tab/delete_retreat_form.php');
    toggleOverlay();
}

// For each button that pulls up an overlay on the couple screen
function coupleButton(url, id) {
    $("#specialBox").find('#specialBoxWrapper').load('couple_tab/' + url, 'coupleID=' + id);
    toggleOverlay();
}

// Send overlay form to PHP script
function sendOverlay(formID, url, tab) {
	$("#"+formID).on("submit", function (event) {
        event.preventDefault();
        var str = $(this).serialize();
	console.log(str);
	$.post(url, str, toggleOverlay());
    });
}

