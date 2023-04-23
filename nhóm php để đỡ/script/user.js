function get_history_id(){
    $(document).on('click','#btn_show',function(){
        var id = $(this).attr('data-id');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "func/get_order_food_detail_ajax.php?id="+id,true);
        xmlhttp.send();
        let modalBody = document.querySelector(".bill_food_detail");
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if(this.status == 200){
                    let result = JSON.parse(this.responseText);

                    modalBody.innerHTML="";
                    let i=1;
                    result.forEach(singleItem=>{
                        modalBody.innerHTML += `                            
                        <tr>
                            <th scope="row">${i++}</th>
                            <td class="food-name-item-cart">${singleItem['name']}</td>
                            <td class="food-added-price">$ ${singleItem['price']}</td>
                            <td class="amount-food-added">${singleItem['num_item']}</td>
                        </tr>`
                    });



                } else {
                    alert('Error Code: ' +  objXMLHttpRequest.status);
                    alert('Error Message: ' + objXMLHttpRequest.statusText);
                }
            }
        }

    //     objXMLHttpRequest.open('GET', 'get_order_food_detail_ajax.php?id='+id,true);
    //     objXMLHttpRequest.send();
    //     var objXMLHttpRequest = new XMLHttpRequest();
    //     objXMLHttpRequest.onreadystatechange = function() {
    //     if(objXMLHttpRequest.readyState === 4) {
    //         if(objXMLHttpRequest.status === 200) {
    //         console.log(JSON_parse(this.responseText));
    //         } else {
    //             ('Error Code: ' +  objXMLHttpRequest.status);
    //             alert('Error Message: ' + objXMLHttpRequest.statusText);
    //         }
    //     }
    // }
    
    })
}
