$(function() {
    $(".calendar").datepicker({
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        minDate: new Date(),
        maxDate: '1M'
    });

    $(document).on('click', '.date-picker .input', function(e) {
        var $me = $(this),
            $parent = $me.parents('.date-picker');
        $parent.toggleClass('open');
    });

    $(".calendar").on("change", function() {
        var $me = $(this),
            $selected = $me.val(),
            $parent = $me.parents('.date-picker');
        $parent.find('.result').children('input')[0].value = $selected;
        $parent.toggleClass('open');
    });

    var bindDatePicker = function() {
        $("#timepicker").datetimepicker({
            format: 'HH:mm',
            stepping: 30,
            enabledHours: [10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
            icons: {
                time: "fas fa-clock",
                up: "fas fa-arrow-up",
                down: "fas fa-arrow-down"
            }
        })
    }

    bindDatePicker();

    $("#spinner").spinner({ min: 1, max: 8, value: 1 });
    $('.ui-spinner a.ui-spinner-button').css('display', 'none');
    $('button').button();

    $('#stepUp').click(function() {
        $("#spinner").spinner("stepUp");
    });

    $('#stepDown').click(function() {
        $("#spinner").spinner("stepDown");
    });
});

let inputDate = document.querySelector("input.date-booking");
let inputTime = document.querySelector("input.time-booking");
let inputAmountPeople = document.querySelector("input.amount-people-booking");
let bookingSection = document.querySelector(".booking-section");
let bookingSectionNote = document.querySelector(".booking-section-note");

let last_check_availability = {
    date: "",
    time: "",
    num_people: ""
};

function get_table_data(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "func/get_info_table_ajax.php?date=" + inputDate.value + "&time=" + inputTime.value + "&people_num=" + inputAmountPeople.value, true);
    xmlhttp.send();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if(this.status == 200){
                last_check_availability["date"] = inputDate.value;
                last_check_availability["time"] = inputTime.value;
                last_check_availability["num_people"] = inputAmountPeople.value;

                bookingSection.innerHTML = `<div class="current-viewing">
                    <p class="text-center fs-30px mt-5 mb-0"></p>
                    <div class="d-flex justify-content-center">
                        <p class="text-success fs-5 mx-3 me-4">Green: can book</p>
                        <p class="text-danger fs-5 mx-3 me-4">Red: already booked</p>
                        <p class="text-mute fs-5 mx-3 me-4">Grey: not suitable</p>                    
                    </div>
                </div>
                <div class="px-md-5 pb-md-5 pt-md-1 pt-4 overflow-auto">
                    <div class="d-md-flex justify-content-center">
                        <div class="bg-white table-section-wrapper p-3">
                            <!-- row 1 -->
                            <div class="row">
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="1" onclick="form_to_book_table(this.id)">1</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="2" onclick="form_to_book_table(this.id)">2</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="3" onclick="form_to_book_table(this.id)">3</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="4" onclick="form_to_book_table(this.id)">4</button>
                                </div>
                            </div>

                            <!-- row 2 -->
                            <div class="row mt-4">
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="5" onclick="form_to_book_table(this.id)">5</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="6" onclick="form_to_book_table(this.id)">6</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="7" onclick="form_to_book_table(this.id)">7</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="8" onclick="form_to_book_table(this.id)">8</button>
                                </div>
                            </div>

                            <!-- row 3 -->
                            <div class="row mt-4">
                                <div class="col-3 text-center align-self-center position-relative">
                                    <img src="images/design_web/eight_seats.png" alt="eight seats image">
                                    <button class="eight-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-40 left-40" id="9" onclick="form_to_book_table(this.id)">9</button>
                                </div>
                                <div class="col-6 text-center position-relative">
                                    <div class="row">
                                        <div class="col-12 position-relative">
                                            <img src="images/design_web/six_seats.png" alt="six seats image">
                                            <button class="six-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-40 left-45" id="10" onclick="form_to_book_table(this.id)">10</button>
                                        </div>
                                        <div class="col-12 mt-4 position-relative">
                                            <img src="images/design_web/six_seats.png" alt="six seats image">
                                            <button class="six-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-40 left-45" id="11" onclick="form_to_book_table(this.id)">11</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 text-center align-self-center position-relative">
                                    <img src="images/design_web/eight_seats.png" alt="eight seats image">
                                    <button class="eight-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-40 left-40" id="12" onclick="form_to_book_table(this.id)">12</button>
                                </div>
                            </div>

                            <!-- row 4 -->
                            <div class="row mt-4">
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="13" onclick="form_to_book_table(this.id)">13</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="14" onclick="form_to_book_table(this.id)">14</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="15" onclick="form_to_book_table(this.id)">15</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="16" onclick="form_to_book_table(this.id)">16</button>
                                </div>
                            </div>

                            <!-- row 5 -->
                            <div class="row mt-4">
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="17" onclick="form_to_book_table(this.id)">17</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="18" onclick="form_to_book_table(this.id)">18</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="19" onclick="form_to_book_table(this.id)">19</button>
                                </div>
                                <div class="col-3 text-center position-relative">
                                    <img src="images/design_web/four_seats.png" alt="four seats image">
                                    <button class="four-seat-button rounded position-absolute btn btn-success px-2 py-1 table-book-btn top-30 left-40" id="20" onclick="form_to_book_table(this.id)">20</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
                
                let currentViewingSentence = document.querySelector(".booking-section .current-viewing p");
                currentViewingSentence.innerText = "Checking table for " + inputAmountPeople.value + " person(s) on " + inputDate.value + " at " + inputTime.value;

                bookingSectionNote.classList.add("d-none");
                let allButtonTableList = document.querySelectorAll(".booking-section button");

                if(inputAmountPeople.value <= 4){
                    setSixSeatUnsuitable();
                    setEightSeatUnsuitable();
                }
                else if(inputAmountPeople.value > 4 && inputAmountPeople.value <= 6){
                    setFourSeatUnsuitable();
                    setEightSeatUnsuitable();
                }                        
                else {
                    setFourSeatUnsuitable();
                    setSixSeatUnsuitable();
                }

                // console.log(JSON.parse(this.response));
                let table_booked = JSON.parse(this.response);
                for (let i = 0; i < table_booked.length; i++) {
                    allButtonTableList[table_booked[i]['table_id'] - 1].classList.remove("btn-success");
                    allButtonTableList[table_booked[i]['table_id'] - 1].classList.add("btn-danger");
                    allButtonTableList[table_booked[i]['table_id'] - 1].classList.add("pe-none");     
                }
            } else {
                alert('Error Code: ' +  objXMLHttpRequest.status);
                alert('Error Message: ' + objXMLHttpRequest.statusText);
          }
        }
    };

    function setFourSeatUnsuitable(){
        let fourSeatButtonTableList = document.querySelectorAll(".booking-section button.four-seat-button");
        for (let i = 0; i < fourSeatButtonTableList.length; i++) {
            fourSeatButtonTableList[i].classList.remove("btn-success");
            fourSeatButtonTableList[i].classList.add("btn-secondary");
            fourSeatButtonTableList[i].classList.add("pe-none");
        }
    }

    function setSixSeatUnsuitable(){
        let sixSeatButtonTableList = document.querySelectorAll(".booking-section button.six-seat-button");
        for (let i = 0; i < sixSeatButtonTableList.length; i++) {
            sixSeatButtonTableList[i].classList.remove("btn-success");
            sixSeatButtonTableList[i].classList.add("btn-secondary");
            sixSeatButtonTableList[i].classList.add("pe-none");
        }
    }

    function setEightSeatUnsuitable(){
        let eightSeatButtonTableList = document.querySelectorAll(".booking-section button.eight-seat-button");
        for (let i = 0; i < eightSeatButtonTableList.length; i++) {
            eightSeatButtonTableList[i].classList.remove("btn-success");
            eightSeatButtonTableList[i].classList.add("btn-secondary");
            eightSeatButtonTableList[i].classList.add("pe-none");
        }
    }
}

function form_to_book_table(table_id){
    var final_booking_table_form = document.createElement("form");
    var final_select_date = document.createElement("input"); 
    var final_select_time = document.createElement("input");  
    var final_select_amount_people = document.createElement("input");
    var final_select_table_id = document.createElement("input");

    final_booking_table_form.method = "POST";
    final_booking_table_form.action = "payment.php?payfor=booking_table";   

    final_select_date.value= last_check_availability["date"];
    final_select_date.name="date";
    final_booking_table_form.appendChild(final_select_date);  

    final_select_time.value= last_check_availability["time"];
    final_select_time.name="time";
    final_booking_table_form.appendChild(final_select_time);

    final_select_amount_people.value= last_check_availability["num_people"];
    final_select_amount_people.name="amount_people";
    final_booking_table_form.appendChild(final_select_amount_people);

    final_select_table_id.value= table_id;
    final_select_table_id.name="table_id";
    final_booking_table_form.appendChild(final_select_table_id);

    document.body.appendChild(final_booking_table_form);

    final_booking_table_form.submit();
}