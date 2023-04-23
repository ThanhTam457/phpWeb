//html btn select
mainCourseBtn = document.querySelector("button.btn.main-course-btn")
beverageBtn = document.querySelector("button.btn.beverage-btn")

//html select area
mainCourseList = document.querySelector(".main-coursed")
beverageList = document.querySelector(".beverage")

//add event listener to btn
mainCourseBtn.addEventListener("click", showMainCourse)
beverageBtn.addEventListener("click", showBeverage)


//function
function showMainCourse() {
    mainCourseList.classList.remove("d-none")
    beverageList.classList.add("d-none")
}

function showBeverage() {
    beverageList.classList.remove("d-none")
    mainCourseList.classList.add("d-none")
}