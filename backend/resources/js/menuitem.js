var MenuItem = {
    setType: function(e, type) {
        var muted = (type === "url") ? "webpage_id" : "url";
        var container = $(e).closest(".menu-item-form");
        container.find(".field-menuitem-" + type).removeClass("disabled-group");
        container.find(".field-menuitem-" + muted).addClass("disabled-group");
    }
};