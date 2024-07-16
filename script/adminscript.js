function openNav() {
    document.getElementById("sidebar").style.width = "250px";
  }
  
  function closeNav()
  {
      document.getElementById("sidebar").style.width = "0px";
    document.getElementById("main").style.marginLeft = "0px";
  }

  function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

document.getElementById("addproductform").addEventListener("submit", formfunction);

function formfunction(event) {
    
    var price=document.getElementById("productprice").value;
    var qty = document.getElementById("productqty").value;
    var qtyValue = Number(qty);

    if (qtyValue <= 0 || price <=0) {
        event.preventDefault();
        alert("Quantity and price must be positive and more than 0!");
    } 
    
}


downarrow=document.getElementById("downarrow").addEventListener("click", downfunction);

function downfunction() {
    var content = document.getElementById("hy");
    if (content.style.display === "none") {
        content.style.display = "block";
    } else {
        content.style.display = "none";
    }
}