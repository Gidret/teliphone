let passwords = document.querySelectorAll('.passwords');
let messages = document.querySelector('#passMessage');
const form = document.querySelector("form");

let checkPasswords = () =>{
    if (passwords[0].value !== passwords[1].value){
        messages.style.color = "red";
        messages.textContent = "Пароль не совпадает!";
        return false;
    } else {
        messages.style.color = "green";
        messages.textContent = "Пароли совпадают!";
        return true;
    }
};


passwords.forEach((elem) => {
    elem.addEventListener("input", checkPasswords);
});

form.addEventListener("submit", (event) => {
    if (!checkPasswords()){
        event.preventDefault();
    }
});