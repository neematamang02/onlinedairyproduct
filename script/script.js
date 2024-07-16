// const one = document.querySelector(".one");
// const two = document.querySelector(".two");
// const three = document.querySelector(".three");
// const four = document.querySelector(".four");
// const five = document.querySelector(".five");

// one.onclick = function() {
//     one.classList.add("active");
//     two.classList.remove("active");
//     three.classList.remove("active");
//     four.classList.remove("active");
//     five.classList.remove("active");
// }

// two.onclick = function() {
//     one.classList.add("active");
//     two.classList.add("active");
//     three.classList.remove("active");
//     four.classList.remove("active");
//     five.classList.remove("active");
// }
// three.onclick = function() {
//     one.classList.add("active");
//     two.classList.add("active");
//     three.classList.add("active");
//     four.classList.remove("active");
//     five.classList.remove("active");
// }
// four.onclick = function() {
// +    one.classList.add("active");
//     two.classList.add("active");
//     three.classList.add("active");
//     four.classList.add("active");
//     five.classList.remove("active");
// }
// five.onclick = function() {
//     one.classList.add("active");
//     two.classList.add("active");
//     three.classList.add("active");
//     four.classList.add("active");
//     five.classList.add("active");
// }

function toggleSidebar() {
    const sidebar = document.querySelector('sidebar');
    sidebar.classList.toggle('collapsed');
}


let email=document.getElementById("email").addEventListener("input",myfunction);
let regxemail=/[a-zA-Z]+[0-9]{0,4}?@{1}[a-z]+\.{1}(com)/g;
function myfunction(e)
{
//     const parent=e.target.closest("div");
//    const p= parent.querySelector("p"); 
//    if(p)
//     {
//         p.remove();
//     }
const p=e.target.nextElementSibling;

    if(regxemail.test(e.target.value)==false)
        {
                // e.target.insertAdjacentHTML("afterend","<p>Email is not valid</p>");
            p.innerText="Email is not valid";
        }
        else{
            p.innerText="";

        }
}


// document.querySelector("form").addEventListener("submit",e=>{
//     e.preventDefault();
    
// })


