let navbar = document.querySelector(".header .navbar");
let accountBox = document.querySelector(".header .account-box");

const menuBtn = document.querySelector("#menu-btn");
if (menuBtn) {
  menuBtn.onclick = () => {
    if (navbar) navbar.classList.toggle("active");
    if (accountBox) accountBox.classList.remove("active");
  };
}

const userBtn = document.querySelector("#user-btn");
if (userBtn) {
  userBtn.onclick = () => {
    if (accountBox) accountBox.classList.toggle("active");
    if (navbar) navbar.classList.remove("active");
  };
}

window.onscroll = () => {
  if (navbar) navbar.classList.remove("active");
  if (accountBox) accountBox.classList.remove("active");
};

const closeUpdate = document.querySelector("#close-update");
if (closeUpdate) {
  closeUpdate.onclick = () => {
    const editForm = document.querySelector(".edit-product-form");
    if (editForm) editForm.style.display = "none";
    window.location.href = "admin_products.php";
  };
}
