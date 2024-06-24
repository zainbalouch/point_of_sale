document.addEventListener('DOMContentLoaded', function () {
    var b = document.querySelectorAll("[data-choices]");
    Array.from(b).forEach(function (e) {
        var t = {}, a = e.attributes;
        a["data-choices-groups"] && (t.placeholderValue = "This is a placeholder set in the config");
        a["data-choices-search-false"] && (t.searchEnabled = !1);
        a["data-choices-search-true"] && (t.searchEnabled = !0);
        a["data-choices-removeItem"] && (t.removeItemButton = !0);
        a["data-choices-sorting-false"] && (t.shouldSort = !1);
        a["data-choices-sorting-true"] && (t.shouldSort = !0);
        a["data-choices-multiple-remove"] && (t.removeItemButton = !0);
        a["data-choices-limit"] && (t.maxItemCount = a["data-choices-limit"].value.toString());
        a["data-choices-limit"] && (t.maxItemCount = a["data-choices-limit"].value.toString());
        a["data-choices-editItem-true"] && (t.maxItemCount = !0);
        a["data-choices-editItem-false"] && (t.maxItemCount = !1);
        a["data-choices-text-unique-true"] && (t.duplicateItemsAllowed = !1);
        a["data-choices-text-disabled-true"] && (t.addItems = !1);
        a["data-choices-text-disabled-true"] ? new Choices(e, t).disable() : new Choices(e, t);
    });
});
