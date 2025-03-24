




// menu-active hs-horizontal start

// minfy
document.addEventListener("DOMContentLoaded",function(){const e=window.location.href,t=document.querySelectorAll('.hs-sub-menu .dropdown-item,.nav-item .nav-link');t.forEach(t=>{if(t.href===e){t.classList.add("active");const o=t.closest(".hs-has-sub-menu")?.querySelector(".hs-mega-menu-invoker");o&&o.classList.add("active")}})});

// normal
document.addEventListener("DOMContentLoaded", function () {
   const currentUrl = window.location.href;
   const menuItems = document.querySelectorAll('.hs-sub-menu .dropdown-item, .nav-item .nav-link');
   menuItems.forEach(item => {
       if (item.href === currentUrl) {
           item.classList.add('active');
           const parentMenu = item.closest('.hs-has-sub-menu').querySelector('.hs-mega-menu-invoker');
           if (parentMenu) {
               parentMenu.classList.add('active');
           }
       }
   });
});

// menu-active hs-horizontal end