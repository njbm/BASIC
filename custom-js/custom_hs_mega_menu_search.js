$(document).on("input", ".global-search", function () {

    var searchQuery = $(this).val().toLowerCase();
    if (searchQuery.length == 0) {
        $(".search-result .content").html("");
        return false;
    }
    $(".search-result .content").html("");

    var matchedLinks = [];

    $("#navbarMegaMenu .nav-item").each(function () {
        var link = $(this).find(".nav-link:not(.dropdown-toggle)");
        if (link.length && link.text().trim().toLowerCase().indexOf(searchQuery) >= 0) {
            matchedLinks.push(link[0]);
        }
    });

    // check dropdown items
    var dropdownLinks = $('.hs-has-sub-menu').find('.hs-sub-menu .dropdown-item');
    dropdownLinks.each(function () {
        if ($(this).text().trim().toLowerCase().indexOf(searchQuery) >= 0) {
            matchedLinks.push(this);
        }
    });

    // Ensure uniqueness
    var uniqueMatchedLinks = [...new Set(matchedLinks)];

    // Display results
    if (uniqueMatchedLinks.length == 0) {
        $(".search-result .content").html(`
            <div class="text-center p-4">
                <div class="dataTables-image oc-error mb-3" data-hs-theme-appearance="default"></div>
                <div class="dataTables-image oc-error-light mb-3" data-hs-theme-appearance="dark"></div>
                <p class="mb-0">No Result Found</p>
            </div>
        `).addClass('d-flex justify-content-center');
    } else {
        uniqueMatchedLinks.forEach(function (link) {
            var title = $(link).find("span").text().replace(/(\d+)/g, "").trim();
            var text = $(link).text().replace(/(\d+)/g, "").trim();
            var linkHref = $(link).attr("href");
            var iconClass = $(link).find("i").attr("class") || "bi-sliders";
            var smallText = $(link).find("small").text().replace(/(\d+)/g, "").trim();

            var displayText = title || text;
            var displaySmallText = smallText || "";

            iconClass = iconClass ? iconClass.replace("dropdown-item-icon", "") : "bi-sliders";

            // Append search result item
            $(".search-result .content").append(`
                <a class="dropdown-item" href="${linkHref}">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <span class="icon icon-soft-dark icon-xs icon-circle">
                                <i class="${iconClass}"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 text-truncate ms-2">
                            <span class="d-block">${displayText}</span>
                            <span class="menu-description">${displaySmallText}</span>
                        </div>
                    </div>
                </a>
            `).removeClass('d-flex justify-content-center');
        });
    }
});



// window.onload = function () {
//     let formSearch = new HSFormSearch(".js-form-search");
//
//     if (formSearch.collection.length) {
//         formSearch.getItem(1).on("close", function (event) {
//             event.classList.remove("top-0");
//         });
//
//         document.querySelector(".js-form-search-mobile-toggle").addEventListener("click", function (event) {
//             let options = JSON.parse(event.currentTarget.getAttribute("data-hs-form-search-options"));
//             let dropMenu = document.querySelector(options.dropMenuElement);
//
//             dropMenu.classList.add("top-0");
//             dropMenu.style.left = 0;
//         });
//     }
// };

