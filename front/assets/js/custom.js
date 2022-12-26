$(document).on("click", ".open-modal", function () {
  var dataModalId = $(this).attr("id");
  $("body").find('.modal[data-id="' + dataModalId + '"]').addClass("active");
  $("body").addClass("over-hide");
});
$(document).on("click", ".close_modal", function () {
  $(this).parents(".modal").removeClass("active");
  $("body").removeClass("over-hide");
});

$(".fl_items").on("click", function () {
  $(this).siblings(".file-list").show();
  $(this).parent().siblings().find(".file-list").hide();
});
$(document).mouseup(function (e) {
  var container = $(".file-list, #shareItems");
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    container.hide();
  }
});

$(".tag-main").on("click", function () {
  $(this).toggleClass("active");
  $(this).siblings().slideToggle();
});

$(".filter-list .filter-btn").on("click", function () {
  $(this).siblings(".filter-box").addClass("active");
});

$(document).mouseup(function (e) {
  var container = $(".filter-box");
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    container.removeClass("active");
  }
});

$(".filter-box li").on("click", function () {
  let thisVal = $(this).attr("value");
  console.log(thisVal);
  $(this).parent().removeClass("active");
  $(this).parents(".filter-list").find(".filter-text").text(thisVal);

});

$(".tab-list li a").on("click", function (e) {
  e.preventDefault()
  $(this).addClass("active");
  $(this).parent("li").siblings().find("a").removeClass("active");

  let tabAttr = $(this).attr("href").split("#")[1];

  $(this).parents(".tab-section").find(".tab-items-list").children('.tab-item[id="' + tabAttr + '"]').fadeIn();
  $(this).parents(".tab-section").find(".tab-items-list").children('.tab-item[id="' + tabAttr + '"]').siblings().hide();

});

$(".toggle-close").on("click", function () {
  $(this).parent().toggleClass("active");
})

function sortFunc() {
  $("#sortBox").toggleClass("active");
}

function closeFilter() {
  $("#sortBox").removeClass("active");
}


// $("#search").on("input", function(){

//   if($(this).val()==''){

//     $("#searchBox").hide();
//     $(this).parents(".search-box").removeClass("active");
//   }

//   else{
//     $("#searchBox").fadeIn();
//     $(this).parents(".search-box").addClass("active");
//   }


// });

$(".search-list li a").on("click", function (e) {
  e.preventDefault();
  $("#loader").show();

  setTimeout(function () {
    $("#loader").hide();
    // $(this).attr("href", "property-detail.html");
    // window.location.href = "property-detail.html";

  }, 1000)

});


$(".st-open-modal").on("click", function () {
  var dataModal = $(this).attr("href").split('#')[1];
  console.log(dataModal);
  $("body").addClass("over-hide");
  $("body").find('.st-modal[data-modal="' + dataModal + '"]').addClass("active");
});

// console.log(form_session);
// if (form_session != 1) {
//   setTimeout(function () {
//     $("body").find('.st-modal[data-modal="formModal"]').addClass("active");
//   }, 10000);
// }

setTimeout(function () {
    // $("body").find('.st-modal[data-modal="formModal"]').addClass("active");
  }, 10000);


$(".ds-close").on("click", function () {
  $(this).parents(".st-modal").removeClass("active");
  $("body").removeClass("over-hide");

});



