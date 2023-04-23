//default at load page, another value: main coursed, dessert, beverage
//depend on id of button select categories
let currentSelectCategories = "all food";

let listFoodAreaRow = document.querySelector(".list-food-area .container .row");
let foodListAddedTableBody = document.querySelector("table.food-list-added-table tbody");
let totalPay = document.querySelector(".modal-footer h4.total-pay span");

let checkoutBtn = document.querySelector('button.go-checkout');
checkCartEmpty();

$(function() {
    $('.selection-categories button.btn').click(function() {      
        if(this.classList.contains("selection-unactive")){
            $(this).closest('.row.mt-2').find('.selection-active').addClass('selection-unactive').removeClass('selection-active');
            $(this).removeClass('selection-unactive').addClass('selection-active');

            currentSelectCategories = this.id;

            //remove old pagination
            $('.pagination').empty();
            $('.pagination').removeData("twbs-pagination");
            $('.pagination').unbind("page");

            let newTotalPage;

            switch(currentSelectCategories){
                case "all food":
                    newTotalPage = foodCountList['num_all'];
                    break;
                case "main coursed":
                    newTotalPage = foodCountList['num_main_courses'];
                    break;
                case "dessert":
                    newTotalPage = foodCountList['num_desserts'];
                    break;
                case "beverage":
                    newTotalPage = foodCountList['num_beverages'];
                    break;
            }

            newTotalPage = newTotalPage / 9 + 1;

            //restart new pagination
            $('.pagination').twbsPagination({
                totalPages: newTotalPage,
                visiblePages: 4,
                currentPage: 1,
                onPageClick: pageChangeFunction  
            });            
        }
    });


    //at default
    $('.pagination').twbsPagination({
        totalPages: foodCountList['num_all'] / 9 + 1,
        visiblePages: 4,
        currentPage: 1,
        onPageClick: pageChangeFunction  
    });
});

function pageChangeFunction (event, page) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "func/get_food_list_ajax.php?category=" + currentSelectCategories + "&page=" + page, true);
    xmlhttp.send();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            if(this.status == 200){
                listFoodAreaRow.innerHTML = "";
                let food_list = JSON.parse(this.response);

                food_list.forEach(eachFood =>{
                    listFoodAreaRow.innerHTML += 
                    `<div class="food-info-wrapper col-lg-4 col-sm-6 mt-5">
                        <div class="card position-relative">
                            <img src="${eachFood["img"]}" class="card-img-top">
                            <div class="card-body text-center position-absolute">
                                <h3 class="card-title m-0">${eachFood["name"]}</h3>
                                <p class="wave-divider my-4"></p>
                                <p class="card-text fw-bold text-orange">$ ${eachFood["price"]}</p>
                                <div class="row">
                                    <div class="amount-food d-flex border-radius-25px col-9">
                                        <input name="amount-food" type='text' class="amount-food-spinner form-control pe-none left-border-radius-25px h-100 ps-4" value="0" />
                                        <button type="button" class="btn btn-secondary p-2 rounded-0 stepUp"><i class="fa-solid fa-arrow-up"></i></button>
                                        <button type="button" class="btn btn-secondary p-2 right-border-radius-25px stepDown"><i class="fa-solid fa-arrow-down"></i></button>
                                    </div>
                                    <div class="col-3 d-flex ps-0">
                                        <button class="btn btn-success p-0 w-100 add-shopping-cart border-radius-25px" data-id-food="${eachFood['id']}"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                });

                $(".amount-food-spinner").spinner({ min: 0, value: 0, step: 1 });
                $('.ui-spinner a.ui-spinner-button').css('display', 'none');
                $('.stepUp').click(function() {
                    $(this).closest('.amount-food').find(".amount-food-spinner").spinner("stepUp");
                });

                $('.stepDown').click(function() {
                    $(this).closest('.amount-food').find(".amount-food-spinner").spinner("stepDown");
                });

                $('.add-shopping-cart').click(function() {
                    const amount_select = $(this).closest(".row").find('input.amount-food-spinner')[0].value;
                    const food_id_data = parseInt(this.getAttribute("data-id-food"));

                    if(amount_select > 0){
                        var xmlhttp_2 = new XMLHttpRequest();
                        xmlhttp_2.open("GET", "func/shopping_cart_handle_ajax.php?food_id=" + food_id_data + "&food_amount=" + amount_select, true);
                        xmlhttp_2.send();

                        xmlhttp_2.onreadystatechange = function() {
                            if (this.readyState == 4) {
                                if(this.status == 200){                                    
                                    let food_added = JSON.parse(this.response);
                                    let item_existed = false;

                                    //check if item exist by name, if yes then update the count column
                                    $(foodListAddedTableBody).find("tr").each(function(){
                                        if($(this).find('.food-name-item-cart')[0].innerHTML == food_added['name']){
                                            item_existed = true;
                                            $(this).find('.amount-food-added')[0].innerHTML = parseInt($(this).find('.amount-food-added')[0].innerHTML) + parseInt(amount_select);
                                            
                                            return false; // equal break out for each loop
                                        }
                                    });

                                    if(!item_existed) {
                                        numberFoodItemCart++;
                                        checkCartEmpty();

                                        foodListAddedTableBody.innerHTML += 
                                        `<tr>
                                            <th scope="row">${numberFoodItemCart}</th>
                                            <td class="food-name-item-cart">${food_added["name"]}</td>
                                            <td class="food-added-price">$${food_added["price"]}</td>
                                            <td class="amount-food-added">${amount_select}</td>
                                            <td class="ps-3"><i class="remove-food-item fas fa-trash ms-4" onClick="removeItem(this)"></i></td>
                                        </tr>`
                                    }

                                    totalPay.innerHTML = parseFloat(totalPay.innerHTML) + food_added["price"] * parseFloat(amount_select);

                                    Toast.create("Shopping Cart Upadate", `Add "${food_added['name']}" to shopping cart successfully`, TOAST_STATUS.SUCCESS, 1000);
                                } else {
                                    alert('Error Code: ' +  objXMLHttpRequest.status);
                                    alert('Error Message: ' + objXMLHttpRequest.statusText);
                                }
                            }
                        }

                        $(this).closest(".row").find('input.amount-food-spinner').spinner("value", 0);
                    }
                });
            } else {
                alert('Error Code: ' +  objXMLHttpRequest.status);
                alert('Error Message: ' + objXMLHttpRequest.statusText);
            }
        }
    };
}

function removeItem(element){
    const food_name_removed = $(element).closest("tr").find("td.food-name-item-cart")[0].innerHTML;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", "func/shopping_cart_handle_ajax.php?remove_food_name=" + food_name_removed, true);
    xmlhttp.send();

    const foodRemoveAmount = parseInt($(element).closest("tr").find("td.amount-food-added")[0].innerHTML);

    let foodRemovePrice = $(element).closest("tr").find("td.food-added-price")[0].innerHTML;
    foodRemovePrice = foodRemovePrice.replace('$', '');
    foodRemovePrice = parseFloat(foodRemovePrice);

    totalPay.innerHTML = parseFloat(totalPay.innerHTML) - foodRemovePrice * foodRemoveAmount;

    numberFoodItemCart--;
    checkCartEmpty();
    Toast.create("Shopping Cart Upadate", `Remove "${food_name_removed}" from shopping cart successfully`, TOAST_STATUS.SUCCESS, 1000);
    $(element).closest("tr").remove();

    //reindex
    for (let i = 0; i < numberFoodItemCart; i++) {
        foodListAddedTableBody.children[i].getElementsByTagName("th")[0].innerHTML = i + 1;    
    }
}

function checkCartEmpty() {
    if(numberFoodItemCart <= 0) {
        checkoutBtn.disabled = true;
        checkoutBtn.closest('form').classList.add("pe-block");
    }
    else {
        checkoutBtn.disabled = false;
        checkoutBtn.closest('form').classList.remove("pe-block");
    }
}