//get param
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

//querySelector
const reservationTable = document.querySelector(".list-reservation table tbody");

let currentStatusView = 0; // variable at start page default

//setup at start page
switch (params['view']) {
    case 'reservation':
        $('.pagination').twbsPagination({
            totalPages: reservationCountList['num_unconfirm'] / 10 + 1,
            visiblePages: 4,
            currentPage: 1,
            onPageClick: reservationPageChangeFunction
        });
        break;
    case 'dashboard':
        var dnct1 = document.getElementById('myChart');
        var myChart1 = new Chart(dnct1, {
            type: 'doughnut',
            data: {
                    labels: ["Main Course", "Desert", "Beverage"],
                    datasets: [{
                    label: ["Main Course", "Desert", "Beverage"],
                    data: [totalEachFoodTypeSold['num_main_courses_sold'], 
                           totalEachFoodTypeSold['num_desserts_sold'],
                           totalEachFoodTypeSold['num_beverages_sold']
                        ],
                    borderWidth: 0,
                    hoverOffset: 5,
                    backgroundColor: ['#3d62a1',
                                    '#008faa',
                                    '#4cad7a']
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: "Food Orderd Sort By Categories"
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            footer: (ttItem) => {
                                let sum = 0;
                                let dataArr = ttItem[0].dataset.data;
                                dataArr.map(data => {
                                sum += Number(data);
                                });

                                let percentage = (ttItem[0].parsed * 100 / sum).toFixed(2) + '%';
                                return `Percentage of data: ${percentage}`;
                            }
                        }
                    },
                    datalabels: {
                        formatter: (value, dnct1) => {
                            let sum = 0;
                            let dataArr = dnct1.chart.data.datasets[0].data;
                            dataArr.map(data => {
                                sum += Number(data);
                            });

                            let percentage = (value * 100 / sum).toFixed(2) + '%';
                            return percentage;
                        },
                        color: 'white',
                    },
                    scales: {
                        y: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            },
            plugins: [ChartDataLabels]
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        
        break;
    default:
        break;
}

function reservationPageChangeFunction(event, page){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "func/admin_reservation_ajax.php?page=" + page + "&status=" + currentStatusView, true);
    xmlhttp.send();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if(this.status == 200){
                let reservation_list = JSON.parse(this.response);

                reservationTable.innerHTML = "";
                reservation_list.forEach(eachReservation => {
                    let datetime = new Date(eachReservation['booking_date']);

                    //date
                    let dd = datetime.getDate();
                    let mm = (parseInt(datetime.getMonth()) + 1);
                    if (dd < 10) dd = '0' + dd;
                    if (mm < 10) mm = '0' + mm;
                    const date = dd + '/' + mm + '/' + datetime.getFullYear();

                    //time
                    let hour = datetime.getHours();
                    let minute = datetime.getMinutes();
                    if (hour < 10) hour = '0' + hour;
                    if (minute < 10) minute = '0' + minute;
                    const time = hour + ":" + minute;

                    singleRowReservationHTML = 
                    `<tr class="fs-6">
                        <td class="">${date}</td>
                        <td class="">${time}</td>
                        <td class="">${eachReservation['num_people']}</td>
                        <td class="">${eachReservation['table_id']}</td>
                        <td class="">${eachReservation['F_name'] + " " + eachReservation['L_name']}</td>
                        <td class="">${eachReservation['phone_num']}</td>`;
                        
                    if (currentStatusView == 0) {
                        singleRowReservationHTML += 
                        `<td class=""><span class="badge bg-danger"><i class="fas fa-times me-1"></i>Unconfirm</span></td>
                         <td class="action-confirm-reservation"><button class="btn btn-outline-success py-0 ps-1 pe-2 confirm-reservation-button" data-id-reservation="${eachReservation['id']}"><i class="fas fa-check fs-4 ms-2"></button></td>`;
                    } else {
                        singleRowReservationHTML += `<td class=""><span class="badge bg-success"><i class="fas fa-check me-1"></i>Confirm</span></td>`;
                    }
                    singleRowReservationHTML += `</tr>`;
                    reservationTable.innerHTML += singleRowReservationHTML;
                });

                $(".confirm-reservation-button").click(function(){
                    const reservation_id = parseInt(this.getAttribute("data-id-reservation"));

                    var xmlhttp_2 = new XMLHttpRequest();
                    xmlhttp_2.open("GET", "func/admin_reservation_ajax.php?confirmReservationId=" + reservation_id, true);
                    xmlhttp_2.send();
                    selectedReservationRow = this.closest("tr");

                    xmlhttp_2.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            if(this.status == 200){
                                selectedReservationRow.remove();
                                Toast.create("Reservation Upadate", `Confirm reservation id "${reservation_id}" successfully`, TOAST_STATUS.SUCCESS, 1000);
                            } else {
                                alert('Error Code: ' +  objXMLHttpRequest.status);
                                alert('Error Message: ' + objXMLHttpRequest.statusText);
                                Toast.create("Reservation Error", `Something is wrong with reservation id "${reservation_id}" or can not connect to the server`, TOAST_STATUS.DANGER, 1000);
                            }
                        }
                    }
                });
            } else {
                alert('Error Code: ' +  objXMLHttpRequest.status);
                alert('Error Message: ' + objXMLHttpRequest.statusText);
            }
        }
    };
}

function chagenViewStatusReservation(status){
    currentStatusView = status;
    let newTotalPage;

    //remove old pagination
    $('.pagination').empty();
    $('.pagination').removeData("twbs-pagination");
    $('.pagination').unbind("page");

    if(currentStatusView == 0){
        $(".reservation-action-column")[0].classList.remove('d-none');
        newTotalPage = reservationCountList['num_unconfirm'] / 10 + 1;
    }
    else {
        $(".reservation-action-column")[0].classList.add('d-none');
        newTotalPage = reservationCountList['num_confirm'] / 10 + 1;
    }

    $('.pagination').twbsPagination({
        totalPages: newTotalPage,
        visiblePages: 4,
        currentPage: 1,
        onPageClick: reservationPageChangeFunction
    });
}