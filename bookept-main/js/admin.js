function redirectToSearch() {
    var districtValue = document.getElementById("district").value;
    var wardValue = document.getElementById("ward").value;
    // Xây dựng URL tìm kiếm dựa trên giá trị đã chọn từ cả hai select box
    var searchURL = "admin_orders.php?";
    if (districtValue) {
        searchURL += "district=" + districtValue;
        if (wardValue) {
            searchURL += "&ward=" + wardValue;
        }
    } else if (wardValue) {
        searchURL += "ward=" + wardValue;
    }

    // Chuyển hướng trang tới URL tìm kiếm mới
    window.location = searchURL;
}
// function checkLogin() {
//     let currentUser = JSON.parse(localStorage.getItem("currentuser"));
//     if(currentUser == null || currentUser.userType == 0) {
//         document.querySelector("body").innerHTML = `<div class="access-denied-section">
//             <img class="access-denied-img" src="./image/access-denied.webp" alt="">
//         </div>`
//     } else {
//         document.getElementById("name-acc").innerHTML = currentUser.fullname;
//     }
// }
// window.onload = checkLogin();

//do sidebar open and close
const menuIconButton = document.querySelector(".menu-icon-btn");
const sidebar = document.querySelector(".sidebar");
menuIconButton.addEventListener("click", () => {
    sidebar.classList.toggle("open");
});

// log out admin user
/*
let toogleMenu = document.querySelector(".profile");
let mune = document.querySelector(".profile-cropdown");
toogleMenu.onclick = function () {
    mune.classList.toggle("active");
};
*/

// tab for section
const sidebars = document.querySelectorAll(".sidebar-list-item.tab-content");
const sections = document.querySelectorAll(".section");

for(let i = 0; i < sidebars.length; i++) {
    sidebars[i].onclick = function () {
        document.querySelector(".sidebar-list-item.active").classList.remove("active");
        document.querySelector(".section.active").classList.remove("active");
        sidebars[i].classList.add("active");
        sections[i].classList.add("active");
    };
}

const closeBtn = document.querySelectorAll('.section');
for(let i=0;i<closeBtn.length;i++){
    closeBtn[i].addEventListener('click',(e) => {
        sidebar.classList.add("open");
    })
}
const closeModalBtn = document.querySelector('.modal-close');

// Add an event listener to the close button
closeModalBtn.addEventListener('click', function() {
    // Get the modal element
    const modal = document.querySelector('.modal.detail-order');

    // Remove the "open" class from the modal
    modal.classList.remove('open');
});

function openEditPopup(productId) {
    // Set the value of a hidden input field in your form with the edit ID
    document.querySelectorAll(".add-product-e").forEach(item => {
        item.style.display = "none";
    })
    document.querySelectorAll(".edit-product-e").forEach(item => {
        item.style.display = "block";
    })
    document.querySelector(".edit-product").classList.add("open");
    document.getElementById('edit-product-id').value = productId;
    // Show the pop-up container
    // Add your code to show the pop-up container here
}

var indexCur;
function editProduct() {

    document.querySelectorAll(".edit-product-e").forEach(item => {
        item.style.display = "block";
    })
    document.querySelector(".edit-product").classList.add("open");
    //
}

function getPathImage(path) {
    let patharr = path.split("/");
    return "./image/" + patharr[patharr.length - 1];
}



let btnAddProductIn = document.getElementById("add-product-button");
// btnAddProductIn.addEventListener("click", (e) => {
//     e.preventDefault();
//     let imgProduct = getPathImage(document.querySelector(".upload-image-preview").src)
//     let tenMon = document.getElementById("ten-mon").value;
//     let price = document.getElementById("gia-moi").value;
//     let moTa = document.getElementById("mo-ta").value;
//     let categoryText = document.getElementById("chon-mon").value;
//     if(tenMon == "" || price == "" || moTa == "") {
//         toast({ title: "Warning", message: "Vui lòng nhập đầy đủ thông tin món!", type: "warning", duration: 3000, });
//     } else {
//         if(isNaN(price)) {
//             toast({ title: "Warning", message: "Giá phải ở dạng số!", type: "warning", duration: 3000, });
//         } else {
//             let products = localStorage.getItem("products") ? JSON.parse(localStorage.getItem("products")) : [];
//             let product = {
//                 id: createId(products),
//                 title: tenMon,
//                 img: imgProduct,
//                 category: categoryText,
//                 price: price,
//                 desc: moTa,
//                 status:1
//             };
//             products.unshift(product);
//             localStorage.setItem("products", JSON.stringify(products));
//             toast({ title: "Success", message: "Thêm sản phẩm thành công!", type: "success", duration: 3000});  
//             setDefaultValue();
//             document.querySelector(".add-product").classList.remove("open");
//             showProduct();
//         }
//     }
// });

document.querySelector(".modal-close.product-form").addEventListener("click",() => {
    setDefaultValue();
})

function setDefaultValue() {
    document.querySelector(".upload-image-preview").src = "./image/";
    document.getElementById("ten-mon").value = "";
    document.getElementById("gia-moi").value = "";
    document.getElementById("mo-ta").value = "";
}

// Open Popup Modal
let btnAddProduct = document.getElementById("btn-add-product");
btnAddProduct.addEventListener("click", () => {
    document.querySelector(".add-product").classList.add("open");
});

// Close Popup Modal
let closePopup = document.querySelectorAll(".modal-close");
let modalPopup = document.querySelectorAll(".modal");


for (let i = 0; i < closePopup.length; i++) {
    console.log(closePopup.length);
    closePopup[i].onclick = () => {
        modalPopup[i].classList.remove("open");
    };
}

// On change Image
function uploadImage(el) {
    let path = "./image/" + el.value.split("\\")[2];
    document.querySelector(".upload-image-preview").setAttribute("src", path);
}

function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('imagePreview');

    var reader = new FileReader();
    reader.onload = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}

// Đổi trạng thái đơn hàng

// Show order

// Get Order Details

// Show Order Detail
// function detailOrder(id) {
//     document.querySelector(".modal.detail-order").classList.add("open");
//     let orders = localStorage.getItem("order") ? JSON.parse(localStorage.getItem("order")) : [];
//     let products = localStorage.getItem("order") ? JSON.parse(localStorage.getItem("products")) : [];
//     // Lấy hóa đơn 
//     let order = orders.find((item) => item.id == id);
//     // Lấy chi tiết hóa đơn
//     let ctDon = getOrderDetails(id);
//     let spHtml = `<div class="modal-detail-left"><div class="order-item-group">`;

//     ctDon.forEach((item) => {
//         let detaiSP = products.find(product => product.id == item.id);
//         spHtml += `<div class="order-product">
//             <div class="order-product-left">
//                 <img src="${detaiSP.img}" alt="">
//                 <div class="order-product-info">
//                     <h4>${detaiSP.title}</h4>
//                     <p class="order-product-note"><i class="fa-light fa-pen"></i> ${item.note}</p>
//                     <p class="order-product-quantity">SL: ${item.soluong}<p>
//                 </div>
//             </div>
//             <div class="order-product-right">
//                 <div class="order-product-price">
//                     <span class="order-product-current-price">${vnd(item.price)}</span>
//                 </div>                         
//             </div>
//         </div>`;
//     });
//     spHtml += `</div></div>`;
//     spHtml += `<div class="modal-detail-right">
//         <ul class="detail-order-group">
//             <li class="detail-order-item">
//                 <span class="detail-order-item-left"><i class="fa fa-calendar"></i> Ngày đặt hàng</span>
//                 <span class="detail-order-item-right">${formatDate(order.thoigiandat)}</span>
//             </li>
//             <li class="detail-order-item">
//                 <span class="detail-order-item-left"><i class="fa fa-truck"></i> Hình thức giao</span>
//                 <span class="detail-order-item-right">${order.hinhthucgiao}</span>
//             </li>
//             <li class="detail-order-item">
//             <span class="detail-order-item-left"><i class="fa fa-user"></i> Người nhận</span>
//             <span class="detail-order-item-right">${order.tenguoinhan}</span>
//             </li>
//             <li class="detail-order-item">
//             <span class="detail-order-item-left"><i class="fa fa-phone"></i> Số điện thoại</span>
//             <span class="detail-order-item-right">${order.sdtnhan}</span>
//             </li>
//             <li class="detail-order-item">
//             <span class="detail-order-item-left"><i class="fa fa-credit-card"></i> Phương thức</span>
//             <span class="detail-order-item-right">${order.phuongthuc}</span>
//             </li>
//             <li class="detail-order-item tb">
//                 <span class="detail-order-item-left"><i class="fa fa-clock-o"></i> Thời gian giao</span>
//                 <p class="detail-order-item-b">${(order.thoigiangiao == "" ? "" : (order.thoigiangiao + " - ")) + formatDate(order.ngaygiaohang)}</p>
//             </li>
//             <li class="detail-order-item tb">
//                 <span class="detail-order-item-t"><i class="fa fa-location-arrow"></i> Địa chỉ nhận</span>
//                 <p class="detail-order-item-b">${order.diachinhan}</p>
//             </li>
//             <li class="detail-order-item tb">
//                 <span class="detail-order-item-t"><i class="fa fa-sticky-note"></i> Ghi chú</span>
//                 <p class="detail-order-item-b">${order.ghichu}</p>
//             </li>
//         </ul>
//     </div>`;
//     document.querySelector(".modal-detail-order").innerHTML = spHtml;

//     let classDetailBtn = order.trangthai == 0 ? "btn-chuaxuly" : "btn-daxuly";
//     let textDetailBtn = order.trangthai == 0 ? "Chưa xử lý" : "Đã xử lý";
//     document.querySelector(
//         ".modal-detail-bottom"
//     ).innerHTML = `<div class="modal-detail-bottom-left">
//         <div class="price-total">
//             <span class="thanhtien">Thành tiền</span>
//             <span class="price">${vnd(order.tongtien)}</span>
//         </div>
//     </div>
//     <div class="modal-detail-bottom-right">
//         <button class="modal-detail-btn ${classDetailBtn}" onclick="changeStatus('${order.id}',this)">${textDetailBtn}</button>
//     </div>`;
// }

// Find Order
function findOrder() {
    let tinhTrang = parseInt(document.getElementById("tinh-trang").value);
    let ct = document.getElementById("form-search-order").value;
    let ward = document.getElementById("ward").value;
    let district = document.getElementById("district").value;
    let timeStart = document.getElementById("time-start").value;
    let timeEnd = document.getElementById("time-end").value;
    
    if (timeEnd < timeStart && timeEnd != "" && timeStart != "") {
        alert("Lựa chọn thời gian sai !");
        return;
    }
    let orders = localStorage.getItem("order") ? JSON.parse(localStorage.getItem("order")) : [];
    let result = tinhTrang == 2 ? orders : orders.filter((item) => {
        return item.trangthai == tinhTrang;
    });
    result = ct == "" ? result : result.filter((item) => {
        return (item.khachhang.toLowerCase().includes(ct.toLowerCase()) || item.id.toString().toLowerCase().includes(ct.toLowerCase()));
    });

    if (timeStart != "" && timeEnd == "") {
        result = result.filter((item) => {
            return new Date(item.thoigiandat) >= new Date(timeStart).setHours(0, 0, 0);
        });
    } else if (timeStart == "" && timeEnd != "") {
        result = result.filter((item) => {
            return new Date(item.thoigiandat) <= new Date(timeEnd).setHours(23, 59, 59);
        });
    } else if (timeStart != "" && timeEnd != "") {
        result = result.filter((item) => {
            return (new Date(item.thoigiandat) >= new Date(timeStart).setHours(0, 0, 0) && new Date(item.thoigiandat) <= new Date(timeEnd).setHours(23, 59, 59)
            );
        });
    }
    showOrder(result);
}

function cancelSearchOrder(){
    let orders = localStorage.getItem("order") ? JSON.parse(localStorage.getItem("order")) : [];
    document.getElementById("tinh-trang").value = 2;
    document.getElementById("form-search-order").value = "";
    document.getElementById("time-start").value = "";
    document.getElementById("time-end").value = "";
    showOrder(orders);
}

// Create Object Thong ke
function createObj() {
    let orders = localStorage.getItem("order") ? JSON.parse(localStorage.getItem("order")) : [];
    let products = localStorage.getItem("products") ? JSON.parse(localStorage.getItem("products")) : []; 
    let orderDetails = localStorage.getItem("orderDetails") ? JSON.parse(localStorage.getItem("orderDetails")) : []; 
    let result = [];
    orderDetails.forEach(item => {
        // Lấy thông tin sản phẩm
        let prod = products.find(product => {return product.id == item.id;});
        let obj = new Object();
        obj.id = item.id;
        obj.madon = item.madon;
        obj.price = item.price;
        obj.quantity = item.soluong;
        obj.category = prod.category;
        obj.title = prod.title;
        obj.img = prod.img;
        obj.time = (orders.find(order => order.id == item.madon)).thoigiandat;
        result.push(obj);
    });
    return result;
}

// Filter 
function thongKe(mode) {
    let categoryTk = document.getElementById("the-loai-tk").value;
    let ct = document.getElementById("form-search-tk").value;
    let timeStart = document.getElementById("time-start-tk").value;
    let timeEnd = document.getElementById("time-end-tk").value;
    if (timeEnd < timeStart && timeEnd != "" && timeStart != "") {
        alert("Lựa chọn thời gian sai !");
        return;
    }
    let arrDetail = createObj();
    let result = categoryTk == "Tất cả" ? arrDetail : arrDetail.filter((item) => {
        return item.category == categoryTk;
    });

    result = ct == "" ? result : result.filter((item) => {
        return (item.title.toLowerCase().includes(ct.toLowerCase()));
    });

    if (timeStart != "" && timeEnd == "") {
        result = result.filter((item) => {
            return new Date(item.time) > new Date(timeStart).setHours(0, 0, 0);
        });
    } else if (timeStart == "" && timeEnd != "") {
        result = result.filter((item) => {
            return new Date(item.time) < new Date(timeEnd).setHours(23, 59, 59);
        });
    } else if (timeStart != "" && timeEnd != "") {
        result = result.filter((item) => {
            return (new Date(item.time) > new Date(timeStart).setHours(0, 0, 0) && new Date(item.time) < new Date(timeEnd).setHours(23, 59, 59)
            );
        });
    }    
    showThongKe(result,mode);
}

// Show số lượng sp, số lượng đơn bán, doanh thu




// User
let addAccount = document.getElementById('signup-button');
let updateAccount = document.getElementById("btn-update-account")


function openCreateAccount() {
    document.querySelector(".signup").classList.add("open");
    document.querySelectorAll(".edit-account-e").forEach(item => {
        item.style.display = "none"
    })
    document.querySelectorAll(".add-account-e").forEach(item => {
        item.style.display = "block"
    })
}

function signUpFormReset() {
    document.getElementById('fullname').value = ""
    document.getElementById('phone').value = ""
    document.getElementById('password').value = ""
    document.querySelector('.form-message-name').innerHTML = '';
    document.querySelector('.form-message-phone').innerHTML = '';
    document.querySelector('.form-message-password').innerHTML = '';
}

// function showUserArr(arr) {
//     let accountHtml = '';
//     if(arr.length == 0) {
//         accountHtml = `<td colspan="5">Không có dữ liệu</td>`
//     } else {
//         arr.forEach((account, index) => {
//             let tinhtrang = account.status == 0 ? `<span class="status-no-complete">Bị khóa</span>` : `<span class="status-complete">Hoạt động</span>`;
//             accountHtml += ` <tr>
//             <td>${index + 1}</td>
//             <td>${account.fullname}</td>
//             <td>${account.phone}</td>
//             <td>${formatDate(account.join)}</td>
//             <td>${tinhtrang}</td>
//             <td class="control control-table">
//             <button class="btn-edit" id="edit-account" onclick='editAccount(${account.phone})' ><i class="fa fa-pencil"></i></button>
//             <button class="btn-delete" id="delete-account" onclick="deleteAcount(${index})"><i class="fa fa-trash"></i></button>
//             </td>
//         </tr>`
//         })
//     }
//     document.getElementById('show-user').innerHTML = accountHtml;
// }

// function showUser() {
//     let tinhTrang = parseInt(document.getElementById("tinh-trang-user").value);
//     let ct = document.getElementById("form-search-user").value;
//     let timeStart = document.getElementById("time-start-user").value;
//     let timeEnd = document.getElementById("time-end-user").value;

//     if (timeEnd < timeStart && timeEnd != "" && timeStart != "") {
//         alert("Lựa chọn thời gian sai !");
//         return;
//     }

//     let accounts = localStorage.getItem("accounts") ? JSON.parse(localStorage.getItem("accounts")).filter(item => item.userType == 0) : [];
//     let result = tinhTrang == 2 ? accounts : accounts.filter(item => item.status == tinhTrang);

//     result = ct == "" ? result : result.filter((item) => {
//         return (item.fullname.toLowerCase().includes(ct.toLowerCase()) || item.phone.toString().toLowerCase().includes(ct.toLowerCase()));
//     });

//     if (timeStart != "" && timeEnd == "") {
//         result = result.filter((item) => {
//             return new Date(item.join) >= new Date(timeStart).setHours(0, 0, 0);
//         });
//     } else if (timeStart == "" && timeEnd != "") {
//         result = result.filter((item) => {
//             return new Date(item.join) <= new Date(timeEnd).setHours(23, 59, 59);
//         });
//     } else if (timeStart != "" && timeEnd != "") {
//         result = result.filter((item) => {
//             return (new Date(item.join) >= new Date(timeStart).setHours(0, 0, 0) && new Date(item.join) <= new Date(timeEnd).setHours(23, 59, 59)
//             );
//         });
//     }
//     showUserArr(result);
// }

function cancelSearchUser() {
    let accounts = localStorage.getItem("accounts") ? JSON.parse(localStorage.getItem("accounts")).filter(item => item.userType == 0) : [];
    showUserArr(accounts);
    document.getElementById("tinh-trang-user").value = 2;
    document.getElementById("form-search-user").value = "";
    document.getElementById("time-start-user").value = "";
    document.getElementById("time-end-user").value = "";
}

// window.onload = showUser();

function deleteAcount(phone) {
    let accounts = JSON.parse(localStorage.getItem('accounts'));
    let index = accounts.findIndex(item => item.phone == phone);
    if (confirm("Bạn có chắc muốn xóa?")) {
        accounts.splice(index, 1)
    }
    localStorage.setItem("accounts", JSON.stringify(accounts));
    showUser();
}

let indexFlag;
function editAccount(phone) {
    document.querySelector(".signup").classList.add("open");
    document.querySelectorAll(".add-account-e").forEach(item => {
        item.style.display = "none"
    })
    document.querySelectorAll(".edit-account-e").forEach(item => {
        item.style.display = "block"
    })
    let accounts = JSON.parse(localStorage.getItem("accounts"));
    let index = accounts.findIndex(item => {
        return item.phone == phone
    })
    indexFlag = index;
    document.getElementById("fullname").value = accounts[index].fullname;
    document.getElementById("phone").value = accounts[index].phone;
    document.getElementById("password").value = accounts[index].password;
    document.getElementById("user-status").checked = accounts[index].status == 1 ? true : false;
}


document.getElementById("logout-acc").addEventListener('click', (e) => {
    e.preventDefault();
    localStorage.removeItem("currentuser");
    window.location = "index.html";
})

